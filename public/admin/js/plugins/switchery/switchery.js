(function () {
    function require(name) {
        var module = require.modules[name];
        if (!module) throw new Error('failed to require "' + name + '"');
        if (!("exports" in module) && typeof module.definition === "function") {
            module.client = module.component = true;
            module.definition.call(this, (module.exports = {}), module);
            delete module.definition;
        }
        return module.exports;
    }
    require.loader = "component";
    require.helper = {};
    require.helper.semVerSort = function (a, b) {
        var aArray = a.version.split(".");
        var bArray = b.version.split(".");
        for (var i = 0; i < aArray.length; ++i) {
            var aInt = parseInt(aArray[i], 10);
            var bInt = parseInt(bArray[i], 10);
            if (aInt === bInt) {
                var aLex = aArray[i].substr(("" + aInt).length);
                var bLex = bArray[i].substr(("" + bInt).length);
                if (aLex === "" && bLex !== "") return 1;
                if (aLex !== "" && bLex === "") return -1;
                if (aLex !== "" && bLex !== "") return aLex > bLex ? 1 : -1;
                continue;
            } else if (aInt > bInt) {
                return 1;
            } else {
                return -1;
            }
        }
        return 0;
    };
    require.latest = function (name, returnPath) {
        function showError(name) {
            throw new Error('failed to find latest module of "' + name + '"');
        }
        var versionRegexp = /(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;
        var remoteRegexp = /(.*)~(.*)/;
        if (!remoteRegexp.test(name)) showError(name);
        var moduleNames = Object.keys(require.modules);
        var semVerCandidates = [];
        var otherCandidates = [];
        for (var i = 0; i < moduleNames.length; i++) {
            var moduleName = moduleNames[i];
            if (new RegExp(name + "@").test(moduleName)) {
                var version = moduleName.substr(name.length + 1);
                var semVerMatch = versionRegexp.exec(moduleName);
                if (semVerMatch != null) {
                    semVerCandidates.push({
                        version: version,
                        name: moduleName,
                    });
                } else {
                    otherCandidates.push({
                        version: version,
                        name: moduleName,
                    });
                }
            }
        }
        if (semVerCandidates.concat(otherCandidates).length === 0) {
            showError(name);
        }
        if (semVerCandidates.length > 0) {
            var module = semVerCandidates
                .sort(require.helper.semVerSort)
                .pop().name;
            if (returnPath === true) {
                return module;
            }
            return require(module);
        }
        var module = otherCandidates.sort(function (a, b) {
            return a.name > b.name;
        })[0].name;
        if (returnPath === true) {
            return module;
        }
        return require(module);
    };
    require.modules = {};
    require.register = function (name, definition) {
        require.modules[name] = { definition: definition };
    };
    require.define = function (name, exports) {
        require.modules[name] = { exports: exports };
    };
    require.register(
        "abpetkov~transitionize@0.0.3",
        function (exports, module) {
            module.exports = Transitionize;
            function Transitionize(element, props) {
                if (!(this instanceof Transitionize))
                    return new Transitionize(element, props);
                this.element = element;
                this.props = props || {};
                this.init();
            }
            Transitionize.prototype.isSafari = function () {
                return (
                    /Safari/.test(navigator.userAgent) &&
                    /Apple Computer/.test(navigator.vendor)
                );
            };
            Transitionize.prototype.init = function () {
                var transitions = [];
                for (var key in this.props) {
                    transitions.push(key + " " + this.props[key]);
                }
                this.element.style.transition = transitions.join(", ");
                if (this.isSafari())
                    this.element.style.webkitTransition =
                        transitions.join(", ");
            };
        }
    );
    require.register("ftlabs~fastclick@v0.6.11", function (exports, module) {
        function FastClick(layer) {
            "use strict";
            var oldOnClick,
                self = this;
            this.trackingClick = false;
            this.trackingClickStart = 0;
            this.targetElement = null;
            this.touchStartX = 0;
            this.touchStartY = 0;
            this.lastTouchIdentifier = 0;
            this.touchBoundary = 10;
            this.layer = layer;
            if (!layer || !layer.nodeType) {
                throw new TypeError("Layer must be a document node");
            }
            this.onClick = function () {
                return FastClick.prototype.onClick.apply(self, arguments);
            };
            this.onMouse = function () {
                return FastClick.prototype.onMouse.apply(self, arguments);
            };
            this.onTouchStart = function () {
                return FastClick.prototype.onTouchStart.apply(self, arguments);
            };
            this.onTouchMove = function () {
                return FastClick.prototype.onTouchMove.apply(self, arguments);
            };
            this.onTouchEnd = function () {
                return FastClick.prototype.onTouchEnd.apply(self, arguments);
            };
            this.onTouchCancel = function () {
                return FastClick.prototype.onTouchCancel.apply(self, arguments);
            };
            if (FastClick.notNeeded(layer)) {
                return;
            }
            if (this.deviceIsAndroid) {
                layer.addEventListener("mouseover", this.onMouse, true);
                layer.addEventListener("mousedown", this.onMouse, true);
                layer.addEventListener("mouseup", this.onMouse, true);
            }
            layer.addEventListener("click", this.onClick, true);
            layer.addEventListener("touchstart", this.onTouchStart, false);
            layer.addEventListener("touchmove", this.onTouchMove, false);
            layer.addEventListener("touchend", this.onTouchEnd, false);
            layer.addEventListener("touchcancel", this.onTouchCancel, false);
            if (!Event.prototype.stopImmediatePropagation) {
                layer.removeEventListener = function (type, callback, capture) {
                    var rmv = Node.prototype.removeEventListener;
                    if (type === "click") {
                        rmv.call(
                            layer,
                            type,
                            callback.hijacked || callback,
                            capture
                        );
                    } else {
                        rmv.call(layer, type, callback, capture);
                    }
                };
                layer.addEventListener = function (type, callback, capture) {
                    var adv = Node.prototype.addEventListener;
                    if (type === "click") {
                        adv.call(
                            layer,
                            type,
                            callback.hijacked ||
                                (callback.hijacked = function (event) {
                                    if (!event.propagationStopped) {
                                        callback(event);
                                    }
                                }),
                            capture
                        );
                    } else {
                        adv.call(layer, type, callback, capture);
                    }
                };
            }
            if (typeof layer.onclick === "function") {
                oldOnClick = layer.onclick;
                layer.addEventListener(
                    "click",
                    function (event) {
                        oldOnClick(event);
                    },
                    false
                );
                layer.onclick = null;
            }
        }
        FastClick.prototype.deviceIsAndroid =
            navigator.userAgent.indexOf("Android") > 0;
        FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(
            navigator.userAgent
        );
        FastClick.prototype.deviceIsIOS4 =
            FastClick.prototype.deviceIsIOS &&
            /OS 4_\d(_\d)?/.test(navigator.userAgent);
        FastClick.prototype.deviceIsIOSWithBadTarget =
            FastClick.prototype.deviceIsIOS &&
            /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent);
        FastClick.prototype.needsClick = function (target) {
            "use strict";
            switch (target.nodeName.toLowerCase()) {
                case "button":
                case "select":
                case "textarea":
                    if (target.disabled) {
                        return true;
                    }
                    break;
                case "input":
                    if (
                        (this.deviceIsIOS && target.type === "file") ||
                        target.disabled
                    ) {
                        return true;
                    }
                    break;
                case "label":
                case "video":
                    return true;
            }
            return /\bneedsclick\b/.test(target.className);
        };
        FastClick.prototype.needsFocus = function (target) {
            "use strict";
            switch (target.nodeName.toLowerCase()) {
                case "textarea":
                    return true;
                case "select":
                    return !this.deviceIsAndroid;
                case "input":
                    switch (target.type) {
                        case "button":
                        case "checkbox":
                        case "file":
                        case "image":
                        case "radio":
                        case "submit":
                            return false;
                    }
                    return !target.disabled && !target.readOnly;
                default:
                    return /\bneedsfocus\b/.test(target.className);
            }
        };
        FastClick.prototype.sendClick = function (targetElement, event) {
            "use strict";
            var clickEvent, touch;
            if (
                document.activeElement &&
                document.activeElement !== targetElement
            ) {
                document.activeElement.blur();
            }
            touch = event.changedTouches[0];
            clickEvent = document.createEvent("MouseEvents");
            clickEvent.initMouseEvent(
                this.determineEventType(targetElement),
                true,
                true,
                window,
                1,
                touch.screenX,
                touch.screenY,
                touch.clientX,
                touch.clientY,
                false,
                false,
                false,
                false,
                0,
                null
            );
            clickEvent.forwardedTouchEvent = true;
            targetElement.dispatchEvent(clickEvent);
        };
        FastClick.prototype.determineEventType = function (targetElement) {
            "use strict";
            if (
                this.deviceIsAndroid &&
                targetElement.tagName.toLowerCase() === "select"
            ) {
                return "mousedown";
            }
            return "click";
        };
        FastClick.prototype.focus = function (targetElement) {
            "use strict";
            var length;
            if (
                this.deviceIsIOS &&
                targetElement.setSelectionRange &&
                targetElement.type.indexOf("date") !== 0 &&
                targetElement.type !== "time"
            ) {
                length = targetElement.value.length;
                targetElement.setSelectionRange(length, length);
            } else {
                targetElement.focus();
            }
        };
        FastClick.prototype.updateScrollParent = function (targetElement) {
            "use strict";
            var scrollParent, parentElement;
            scrollParent = targetElement.fastClickScrollParent;
            if (!scrollParent || !scrollParent.contains(targetElement)) {
                parentElement = targetElement;
                do {
                    if (
                        parentElement.scrollHeight > parentElement.offsetHeight
                    ) {
                        scrollParent = parentElement;
                        targetElement.fastClickScrollParent = parentElement;
                        break;
                    }
                    parentElement = parentElement.parentElement;
                } while (parentElement);
            }
            if (scrollParent) {
                scrollParent.fastClickLastScrollTop = scrollParent.scrollTop;
            }
        };
        FastClick.prototype.getTargetElementFromEventTarget = function (
            eventTarget
        ) {
            "use strict";
            if (eventTarget.nodeType === Node.TEXT_NODE) {
                return eventTarget.parentNode;
            }
            return eventTarget;
        };
        FastClick.prototype.onTouchStart = function (event) {
            "use strict";
            var targetElement, touch, selection;
            if (event.targetTouches.length > 1) {
                return true;
            }
            targetElement = this.getTargetElementFromEventTarget(event.target);
            touch = event.targetTouches[0];
            if (this.deviceIsIOS) {
                selection = window.getSelection();
                if (selection.rangeCount && !selection.isCollapsed) {
                    return true;
                }
                if (!this.deviceIsIOS4) {
                    if (touch.identifier === this.lastTouchIdentifier) {
                        event.preventDefault();
                        return false;
                    }
                    this.lastTouchIdentifier = touch.identifier;
                    this.updateScrollParent(targetElement);
                }
            }
            this.trackingClick = true;
            this.trackingClickStart = event.timeStamp;
            this.targetElement = targetElement;
            this.touchStartX = touch.pageX;
            this.touchStartY = touch.pageY;
            if (event.timeStamp - this.lastClickTime < 200) {
                event.preventDefault();
            }
            return true;
        };
        FastClick.prototype.touchHasMoved = function (event) {
            "use strict";
            var touch = event.changedTouches[0],
                boundary = this.touchBoundary;
            if (
                Math.abs(touch.pageX - this.touchStartX) > boundary ||
                Math.abs(touch.pageY - this.touchStartY) > boundary
            ) {
                return true;
            }
            return false;
        };
        FastClick.prototype.onTouchMove = function (event) {
            "use strict";
            if (!this.trackingClick) {
                return true;
            }
            if (
                this.targetElement !==
                    this.getTargetElementFromEventTarget(event.target) ||
                this.touchHasMoved(event)
            ) {
                this.trackingClick = false;
                this.targetElement = null;
            }
            return true;
        };
        FastClick.prototype.findControl = function (labelElement) {
            "use strict";
            if (labelElement.control !== undefined) {
                return labelElement.control;
            }
            if (labelElement.htmlFor) {
                return document.getElementById(labelElement.htmlFor);
            }
            return labelElement.querySelector(
                "button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea"
            );
        };
        FastClick.prototype.onTouchEnd = function (event) {
            "use strict";
            var forElement,
                trackingClickStart,
                targetTagName,
                scrollParent,
                touch,
                targetElement = this.targetElement;
            if (!this.trackingClick) {
                return true;
            }
            if (event.timeStamp - this.lastClickTime < 200) {
                this.cancelNextClick = true;
                return true;
            }
            this.cancelNextClick = false;
            this.lastClickTime = event.timeStamp;
            trackingClickStart = this.trackingClickStart;
            this.trackingClick = false;
            this.trackingClickStart = 0;
            if (this.deviceIsIOSWithBadTarget) {
                touch = event.changedTouches[0];
                targetElement =
                    document.elementFromPoint(
                        touch.pageX - window.pageXOffset,
                        touch.pageY - window.pageYOffset
                    ) || targetElement;
                targetElement.fastClickScrollParent =
                    this.targetElement.fastClickScrollParent;
            }
            targetTagName = targetElement.tagName.toLowerCase();
            if (targetTagName === "label") {
                forElement = this.findControl(targetElement);
                if (forElement) {
                    this.focus(targetElement);
                    if (this.deviceIsAndroid) {
                        return false;
                    }
                    targetElement = forElement;
                }
            } else if (this.needsFocus(targetElement)) {
                if (
                    event.timeStamp - trackingClickStart > 100 ||
                    (this.deviceIsIOS &&
                        window.top !== window &&
                        targetTagName === "input")
                ) {
                    this.targetElement = null;
                    return false;
                }
                this.focus(targetElement);
                if (!this.deviceIsIOS4 || targetTagName !== "select") {
                    this.targetElement = null;
                    event.preventDefault();
                }
                return false;
            }
            if (this.deviceIsIOS && !this.deviceIsIOS4) {
                scrollParent = targetElement.fastClickScrollParent;
                if (
                    scrollParent &&
                    scrollParent.fastClickLastScrollTop !==
                        scrollParent.scrollTop
                ) {
                    return true;
                }
            }
            if (!this.needsClick(targetElement)) {
                event.preventDefault();
                this.sendClick(targetElement, event);
            }
            return false;
        };
        FastClick.prototype.onTouchCancel = function () {
            "use strict";
            this.trackingClick = false;
            this.targetElement = null;
        };
        FastClick.prototype.onMouse = function (event) {
            "use strict";
            if (!this.targetElement) {
                return true;
            }
            if (event.forwardedTouchEvent) {
                return true;
            }
            if (!event.cancelable) {
                return true;
            }
            if (!this.needsClick(this.targetElement) || this.cancelNextClick) {
                if (event.stopImmediatePropagation) {
                    event.stopImmediatePropagation();
                } else {
                    event.propagationStopped = true;
                }
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
            return true;
        };
        FastClick.prototype.onClick = function (event) {
            "use strict";
            var permitted;
            if (this.trackingClick) {
                this.targetElement = null;
                this.trackingClick = false;
                return true;
            }
            if (event.target.type === "submit" && event.detail === 0) {
                return true;
            }
            permitted = this.onMouse(event);
            if (!permitted) {
                this.targetElement = null;
            }
            return permitted;
        };
        FastClick.prototype.destroy = function () {
            "use strict";
            var layer = this.layer;
            if (this.deviceIsAndroid) {
                layer.removeEventListener("mouseover", this.onMouse, true);
                layer.removeEventListener("mousedown", this.onMouse, true);
                layer.removeEventListener("mouseup", this.onMouse, true);
            }
            layer.removeEventListener("click", this.onClick, true);
            layer.removeEventListener("touchstart", this.onTouchStart, false);
            layer.removeEventListener("touchmove", this.onTouchMove, false);
            layer.removeEventListener("touchend", this.onTouchEnd, false);
            layer.removeEventListener("touchcancel", this.onTouchCancel, false);
        };
        FastClick.notNeeded = function (layer) {
            "use strict";
            var metaViewport;
            var chromeVersion;
            if (typeof window.ontouchstart === "undefined") {
                return true;
            }
            chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [
                ,
                0,
            ])[1];
            if (chromeVersion) {
                if (FastClick.prototype.deviceIsAndroid) {
                    metaViewport = document.querySelector(
                        "meta[name=viewport]"
                    );
                    if (metaViewport) {
                        if (
                            metaViewport.content.indexOf("user-scalable=no") !==
                            -1
                        ) {
                            return true;
                        }
                        if (
                            chromeVersion > 31 &&
                            window.innerWidth <= window.screen.width
                        ) {
                            return true;
                        }
                    }
                } else {
                    return true;
                }
            }
            if (layer.style.msTouchAction === "none") {
                return true;
            }
            return false;
        };
        FastClick.attach = function (layer) {
            "use strict";
            return new FastClick(layer);
        };
        if (typeof define !== "undefined" && define.amd) {
            define(function () {
                "use strict";
                return FastClick;
            });
        } else if (typeof module !== "undefined" && module.exports) {
            module.exports = FastClick.attach;
            module.exports.FastClick = FastClick;
        } else {
            window.FastClick = FastClick;
        }
    });
    require.register("component~indexof@0.0.3", function (exports, module) {
        module.exports = function (arr, obj) {
            if (arr.indexOf) return arr.indexOf(obj);
            for (var i = 0; i < arr.length; ++i) {
                if (arr[i] === obj) return i;
            }
            return -1;
        };
    });
    require.register("component~classes@1.2.1", function (exports, module) {
        var index = require("component~indexof@0.0.3");
        var re = /\s+/;
        var toString = Object.prototype.toString;
        module.exports = function (el) {
            return new ClassList(el);
        };
        function ClassList(el) {
            if (!el) throw new Error("A DOM element reference is required");
            this.el = el;
            this.list = el.classList;
        }
        ClassList.prototype.add = function (name) {
            if (this.list) {
                this.list.add(name);
                return this;
            }
            var arr = this.array();
            var i = index(arr, name);
            if (!~i) arr.push(name);
            this.el.className = arr.join(" ");
            return this;
        };
        ClassList.prototype.remove = function (name) {
            if ("[object RegExp]" == toString.call(name)) {
                return this.removeMatching(name);
            }
            if (this.list) {
                this.list.remove(name);
                return this;
            }
            var arr = this.array();
            var i = index(arr, name);
            if (~i) arr.splice(i, 1);
            this.el.className = arr.join(" ");
            return this;
        };
        ClassList.prototype.removeMatching = function (re) {
            var arr = this.array();
            for (var i = 0; i < arr.length; i++) {
                if (re.test(arr[i])) {
                    this.remove(arr[i]);
                }
            }
            return this;
        };
        ClassList.prototype.toggle = function (name, force) {
            if (this.list) {
                if ("undefined" !== typeof force) {
                    if (force !== this.list.toggle(name, force)) {
                        this.list.toggle(name);
                    }
                } else {
                    this.list.toggle(name);
                }
                return this;
            }
            if ("undefined" !== typeof force) {
                if (!force) {
                    this.remove(name);
                } else {
                    this.add(name);
                }
            } else {
                if (this.has(name)) {
                    this.remove(name);
                } else {
                    this.add(name);
                }
            }
            return this;
        };
        ClassList.prototype.array = function () {
            var str = this.el.className.replace(/^\s+|\s+$/g, "");
            var arr = str.split(re);
            if ("" === arr[0]) arr.shift();
            return arr;
        };
        ClassList.prototype.has = ClassList.prototype.contains = function (
            name
        ) {
            return this.list
                ? this.list.contains(name)
                : !!~index(this.array(), name);
        };
    });
    require.register("component~event@0.1.4", function (exports, module) {
        var bind = window.addEventListener ? "addEventListener" : "attachEvent",
            unbind = window.removeEventListener
                ? "removeEventListener"
                : "detachEvent",
            prefix = bind !== "addEventListener" ? "1" : "2";
        exports.bind = function (el, type, fn, capture) {
            el[bind](prefix + type, fn, capture || false);
            return fn;
        };
        exports.unbind = function (el, type, fn, capture) {
            el[unbind](prefix + type, fn, capture || false);
            return fn;
        };
    });
    require.register("component~query@0.0.3", function (exports, module) {
        function one(selector, el) {
            return el.querySelector(selector);
        }
        exports = module.exports = function (selector, el) {
            el = el || document;
            return one(selector, el);
        };
        exports.all = function (selector, el) {
            el = el || document;
            return el.querySelectorAll(selector);
        };
        exports.engine = function (obj) {
            if (!obj.one) throw new Error(".one callback required");
            if (!obj.all) throw new Error(".all callback required");
            one = obj.one;
            exports.all = obj.all;
            return exports;
        };
    });
    require.register(
        "component~matches-selector@0.1.5",
        function (exports, module) {
            var query = require("component~query@0.0.3");
            var proto = Element.prototype;
            var vendor =
                proto.matches ||
                proto.webkitMatchesSelector ||
                proto.mozMatchesSelector ||
                proto.msMatchesSelector ||
                proto.oMatchesSelector;
            module.exports = match;
            function match(el, selector) {
                if (!el || el.nodeType !== 1) return false;
                if (vendor) return vendor.call(el, selector);
                var nodes = query.all(selector, el.parentNode);
                for (var i = 0; i < nodes.length; ++i) {
                    if (nodes[i] == el) return true;
                }
                return false;
            }
        }
    );
    require.register("component~closest@0.1.4", function (exports, module) {
        var matches = require("component~matches-selector@0.1.5");
        module.exports = function (element, selector, checkYoSelf, root) {
            element = checkYoSelf ? { parentNode: element } : element;
            root = root || document;
            while ((element = element.parentNode) && element !== document) {
                if (matches(element, selector)) return element;
                if (element === root) return;
            }
        };
    });
    require.register("component~delegate@0.2.3", function (exports, module) {
        var closest = require("component~closest@0.1.4"),
            event = require("component~event@0.1.4");
        exports.bind = function (el, selector, type, fn, capture) {
            return event.bind(
                el,
                type,
                function (e) {
                    var target = e.target || e.srcElement;
                    e.delegateTarget = closest(target, selector, true, el);
                    if (e.delegateTarget) fn.call(el, e);
                },
                capture
            );
        };
        exports.unbind = function (el, type, fn, capture) {
            event.unbind(el, type, fn, capture);
        };
    });
    require.register("component~events@1.0.9", function (exports, module) {
        var events = require("component~event@0.1.4");
        var delegate = require("component~delegate@0.2.3");
        module.exports = Events;
        function Events(el, obj) {
            if (!(this instanceof Events)) return new Events(el, obj);
            if (!el) throw new Error("element required");
            if (!obj) throw new Error("object required");
            this.el = el;
            this.obj = obj;
            this._events = {};
        }
        Events.prototype.sub = function (event, method, cb) {
            this._events[event] = this._events[event] || {};
            this._events[event][method] = cb;
        };
        Events.prototype.bind = function (event, method) {
            var e = parse(event);
            var el = this.el;
            var obj = this.obj;
            var name = e.name;
            var method = method || "on" + name;
            var args = [].slice.call(arguments, 2);
            function cb() {
                var a = [].slice.call(arguments).concat(args);
                obj[method].apply(obj, a);
            }
            if (e.selector) {
                cb = delegate.bind(el, e.selector, name, cb);
            } else {
                events.bind(el, name, cb);
            }
            this.sub(name, method, cb);
            return cb;
        };
        Events.prototype.unbind = function (event, method) {
            if (0 == arguments.length) return this.unbindAll();
            if (1 == arguments.length) return this.unbindAllOf(event);
            var bindings = this._events[event];
            if (!bindings) return;
            var cb = bindings[method];
            if (!cb) return;
            events.unbind(this.el, event, cb);
        };
        Events.prototype.unbindAll = function () {
            for (var event in this._events) {
                this.unbindAllOf(event);
            }
        };
        Events.prototype.unbindAllOf = function (event) {
            var bindings = this._events[event];
            if (!bindings) return;
            for (var method in bindings) {
                this.unbind(event, method);
            }
        };
        function parse(event) {
            var parts = event.split(/ +/);
            return { name: parts.shift(), selector: parts.join(" ") };
        }
    });
    require.register("switchery", function (exports, module) {
        var transitionize = require("abpetkov~transitionize@0.0.3"),
            fastclick = require("ftlabs~fastclick@v0.6.11"),
            classes = require("component~classes@1.2.1"),
            events = require("component~events@1.0.9");
        module.exports = Switchery;
        var defaults = {
            color: "#64bd63",
            secondaryColor: "#dfdfdf",
            jackColor: "#fff",
            jackSecondaryColor: null,
            className: "switchery",
            disabled: false,
            disabledOpacity: 0.5,
            speed: "0.4s",
            size: "default",
        };
        function Switchery(element, options) {
            if (!(this instanceof Switchery))
                return new Switchery(element, options);
            this.element = element;
            this.options = options || {};
            for (var i in defaults) {
                if (this.options[i] == null) {
                    this.options[i] = defaults[i];
                }
            }
            if (this.element != null && this.element.type == "checkbox")
                this.init();
            if (this.isDisabled() === true) this.disable();
        }
        Switchery.prototype.hide = function () {
            this.element.style.display = "none";
        };
        Switchery.prototype.show = function () {
            var switcher = this.create();
            this.insertAfter(this.element, switcher);
        };
        Switchery.prototype.create = function () {
            this.switcher = document.createElement("span");
            this.jack = document.createElement("small");
            this.switcher.appendChild(this.jack);
            this.switcher.className = this.options.className;
            this.events = events(this.switcher, this);
            return this.switcher;
        };
        Switchery.prototype.insertAfter = function (reference, target) {
            reference.parentNode.insertBefore(target, reference.nextSibling);
        };
        Switchery.prototype.setPosition = function (clicked) {
            var checked = this.isChecked(),
                switcher = this.switcher,
                jack = this.jack;
            if (clicked && checked) checked = false;
            else if (clicked && !checked) checked = true;
            if (checked === true) {
                this.element.checked = true;
                if (window.getComputedStyle)
                    jack.style.left =
                        parseInt(window.getComputedStyle(switcher).width) -
                        parseInt(window.getComputedStyle(jack).width) +
                        "px";
                else
                    jack.style.left =
                        parseInt(switcher.currentStyle["width"]) -
                        parseInt(jack.currentStyle["width"]) +
                        "px";
                if (this.options.color) this.colorize();
                this.setSpeed();
            } else {
                jack.style.left = 0;
                this.element.checked = false;
                this.switcher.style.boxShadow =
                    "inset 0 0 0 0 " + this.options.secondaryColor;
                this.switcher.style.borderColor = this.options.secondaryColor;
                this.switcher.style.backgroundColor =
                    this.options.secondaryColor !== defaults.secondaryColor
                        ? this.options.secondaryColor
                        : "#fff";
                this.jack.style.backgroundColor =
                    this.options.jackSecondaryColor !== this.options.jackColor
                        ? this.options.jackSecondaryColor
                        : this.options.jackColor;
                this.setSpeed();
            }
        };
        Switchery.prototype.setSpeed = function () {
            var switcherProp = {},
                jackProp = {
                    "background-color": this.options.speed,
                    left: this.options.speed.replace(/[a-z]/, "") / 2 + "s",
                };
            if (this.isChecked()) {
                switcherProp = {
                    border: this.options.speed,
                    "box-shadow": this.options.speed,
                    "background-color":
                        this.options.speed.replace(/[a-z]/, "") * 3 + "s",
                };
            } else {
                switcherProp = {
                    border: this.options.speed,
                    "box-shadow": this.options.speed,
                };
            }
            transitionize(this.switcher, switcherProp);
            transitionize(this.jack, jackProp);
        };
        Switchery.prototype.setSize = function () {
            var small = "switchery-small",
                normal = "switchery-default",
                large = "switchery-large";
            switch (this.options.size) {
                case "small":
                    classes(this.switcher).add(small);
                    break;
                case "large":
                    classes(this.switcher).add(large);
                    break;
                default:
                    classes(this.switcher).add(normal);
                    break;
            }
        };
        Switchery.prototype.colorize = function () {
            var switcherHeight = this.switcher.offsetHeight / 2;
            this.switcher.style.backgroundColor = this.options.color;
            this.switcher.style.borderColor = this.options.color;
            this.switcher.style.boxShadow =
                "inset 0 0 0 " + switcherHeight + "px " + this.options.color;
            this.jack.style.backgroundColor = this.options.jackColor;
        };
        Switchery.prototype.handleOnchange = function (state) {
            if (document.dispatchEvent) {
                var event = document.createEvent("HTMLEvents");
                event.initEvent("change", true, true);
                this.element.dispatchEvent(event);
            } else {
                this.element.fireEvent("onchange");
            }
        };
        Switchery.prototype.handleChange = function () {
            var self = this,
                el = this.element;
            if (el.addEventListener) {
                el.addEventListener("change", function () {
                    self.setPosition();
                });
            } else {
                el.attachEvent("onchange", function () {
                    self.setPosition();
                });
            }
        };
        Switchery.prototype.handleClick = function () {
            var switcher = this.switcher;
            fastclick(switcher);
            this.events.bind("click", "bindClick");
        };
        Switchery.prototype.bindClick = function () {
            var parent = this.element.parentNode.tagName.toLowerCase(),
                labelParent = parent === "label" ? false : true;
            this.setPosition(labelParent);
            this.handleOnchange(this.element.checked);
        };
        Switchery.prototype.markAsSwitched = function () {
            this.element.setAttribute("data-switchery", true);
        };
        Switchery.prototype.markedAsSwitched = function () {
            return this.element.getAttribute("data-switchery");
        };
        Switchery.prototype.init = function () {
            this.hide();
            this.show();
            this.setSize();
            this.setPosition();
            this.markAsSwitched();
            this.handleChange();
            this.handleClick();
        };
        Switchery.prototype.isChecked = function () {
            return this.element.checked;
        };
        Switchery.prototype.isDisabled = function () {
            return (
                this.options.disabled ||
                this.element.disabled ||
                this.element.readOnly
            );
        };
        Switchery.prototype.destroy = function () {
            this.events.unbind();
        };
        Switchery.prototype.enable = function () {
            if (!this.options.disabled) return;
            if (this.options.disabled) this.options.disabled = false;
            if (this.element.disabled) this.element.disabled = false;
            if (this.element.readOnly) this.element.readOnly = false;
            this.switcher.style.opacity = 1;
            this.events.bind("click", "bindClick");
        };
        Switchery.prototype.disable = function () {
            if (this.options.disabled) return;
            if (!this.options.disabled) this.options.disabled = true;
            if (!this.element.disabled) this.element.disabled = true;
            if (!this.element.readOnly) this.element.readOnly = true;
            this.switcher.style.opacity = this.options.disabledOpacity;
            this.destroy();
        };
    });
    if (typeof exports == "object") {
        module.exports = require("switchery");
    } else if (typeof define == "function" && define.amd) {
        define("Switchery", [], function () {
            return require("switchery");
        });
    } else {
        (this || window)["Switchery"] = require("switchery");
    }
})();
