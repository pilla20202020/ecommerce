
/*!
 * Bez v1.0.10-g5ae0136
 * http://github.com/rdallasgray/bez
 *
 * A plugin to convert CSS3 cubic-bezier co-ordinates to jQuery-compatible easing functions
 *
 * With thanks to Nikolay Nemshilov for clarification on the cubic-bezier maths
 * See http://st-on-it.blogspot.com/2011/05/calculating-cubic-bezier-function.html
 *
 * Copyright 2011 Robert Dallas Gray. All rights reserved.
 * Provided under the FreeBSD license: https://github.com/rdallasgray/bez/blob/master/LICENSE.txt
*/jQuery.extend({bez:function(a){var b="bez_"+jQuery.makeArray(arguments).join("_").replace(".","p");if(typeof jQuery.easing[b]!="function"){var c=function(a,b){var c=[null,null],d=[null,null],e=[null,null],f=function(f,g){return e[g]=3*a[g],d[g]=3*(b[g]-a[g])-e[g],c[g]=1-e[g]-d[g],f*(e[g]+f*(d[g]+f*c[g]))},g=function(a){return e[0]+a*(2*d[0]+3*c[0]*a)},h=function(a){var b=a,c=0,d;while(++c<14){d=f(b,0)-a;if(Math.abs(d)<.001)break;b-=d/g(b)}return b};return function(a){return f(h(a),1)}};jQuery.easing[b]=function(b,d,e,f,g){return f*c([a[0],a[1]],[a[2],a[3]])(d/g)+e}}return b}});

/*! Copyright 2012, Ben Lin (http://dreamerslab.com/)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 1.0.19
 *
 * Requires: jQuery >= 1.2.3
 */
;( function ( factory ) {
    if ( typeof define === 'function' && define.amd ) {
        // AMD. Register module depending on jQuery using requirejs define.
        define( ['jquery'], factory );
    } else {
        // No AMD.
        factory( jQuery );
    }
}( function ( $ ){
    $.fn.addBack = $.fn.addBack || $.fn.andSelf;

    $.fn.extend({

        actual : function ( method, options ){
            // check if the jQuery method exist
            if( !this[ method ]){
                throw '$.actual => The jQuery method "' + method + '" you called does not exist';
            }

            var defaults = {
                absolute      : false,
                clone         : false,
                includeMargin : false,
                display       : 'block'
            };

            var configs = $.extend( defaults, options );

            var $target = this.eq( 0 );
            var fix, restore;

            if( configs.clone === true ){
                fix = function (){
                    var style = 'position: absolute !important; top: -1000 !important; ';

                    // this is useful with css3pie
                    $target = $target.
                    clone().
                    attr( 'style', style ).
                    appendTo( 'body' );
                };

                restore = function (){
                    // remove DOM element after getting the width
                    $target.remove();
                };
            }else{
                var tmp   = [];
                var style = '';
                var $hidden;

                fix = function (){
                    // get all hidden parents
                    $hidden = $target.parents().addBack().filter( ':hidden' );
                    style   += 'visibility: hidden !important; display: ' + configs.display + ' !important; ';

                    if( configs.absolute === true ) style += 'position: absolute !important; ';

                    // save the origin style props
                    // set the hidden el css to be got the actual value later
                    $hidden.each( function (){
                        // Save original style. If no style was set, attr() returns undefined
                        var $this     = $( this );
                        var thisStyle = $this.attr( 'style' );

                        tmp.push( thisStyle );
                        // Retain as much of the original style as possible, if there is one
                        $this.attr( 'style', thisStyle ? thisStyle + ';' + style : style );
                    });
                };

                restore = function (){
                    // restore origin style values
                    $hidden.each( function ( i ){
                        var $this = $( this );
                        var _tmp  = tmp[ i ];

                        if( _tmp === undefined ){
                            $this.removeAttr( 'style' );
                        }else{
                            $this.attr( 'style', _tmp );
                        }
                    });
                };
            }

            fix();
            // get the actual value with user specific methed
            // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
            // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
            var actual = /(outer)/.test( method ) ?
                $target[ method ]( configs.includeMargin ) :
                $target[ method ]();

            restore();
            // IMPORTANT, this plugin only return the value of the first element
            return actual;
        }
    });
}));

/*!
 * iCheck v1.0.2, http://git.io/arlzeA
 * ===================================
 * Powerful jQuery and Zepto plugin for checkboxes and radio buttons customization
 *
 * (c) 2013 Damir Sultanov, http://fronteed.com
 * MIT Licensed
 */

(function($) {

    // Cached vars
    var _iCheck = 'iCheck',
        _iCheckHelper = _iCheck + '-helper',
        _checkbox = 'checkbox',
        _radio = 'radio',
        _checked = 'checked',
        _unchecked = 'un' + _checked,
        _disabled = 'disabled',a
    _determinate = 'determinate',
        _indeterminate = 'in' + _determinate,
        _update = 'update',
        _type = 'type',
        _click = 'click',
        _touch = 'touchbegin.i touchend.i',
        _add = 'addClass',
        _remove = 'removeClass',
        _callback = 'trigger',
        _label = 'label',
        _cursor = 'cursor',
        _mobile = /ipad|iphone|ipod|android|blackberry|windows phone|opera mini|silk/i.test(navigator.userAgent);

    // Plugin init
    $.fn[_iCheck] = function(options, fire) {

        // Walker
        var handle = 'input[type="' + _checkbox + '"], input[type="' + _radio + '"]',
            stack = $(),
            walker = function(object) {
                object.each(function() {
                    var self = $(this);

                    if (self.is(handle)) {
                        stack = stack.add(self);
                    } else {
                        stack = stack.add(self.find(handle));
                    }
                });
            };

        // Check if we should operate with some method
        if (/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(options)) {

            // Normalize method's name
            options = options.toLowerCase();

            // Find checkboxes and radio buttons
            walker(this);

            return stack.each(function() {
                var self = $(this);

                if (options == 'destroy') {
                    tidy(self, 'ifDestroyed');
                } else {
                    operate(self, true, options);
                }

                // Fire method's callback
                if ($.isFunction(fire)) {
                    fire();
                }
            });

            // Customization
        } else if (typeof options == 'object' || !options) {

            // Check if any options were passed
            var settings = $.extend({
                    checkedClass: _checked,
                    disabledClass: _disabled,
                    indeterminateClass: _indeterminate,
                    labelHover: true
                }, options),

                selector = settings.handle,
                hoverClass = settings.hoverClass || 'hover',
                focusClass = settings.focusClass || 'focus',
                activeClass = settings.activeClass || 'active',
                labelHover = !!settings.labelHover,
                labelHoverClass = settings.labelHoverClass || 'hover',

                // Setup clickable area
                area = ('' + settings.increaseArea).replace('%', '') | 0;

            // Selector limit
            if (selector == _checkbox || selector == _radio) {
                handle = 'input[type="' + selector + '"]';
            }

            // Clickable area limit
            if (area < -50) {
                area = -50;
            }

            // Walk around the selector
            walker(this);

            return stack.each(function() {
                var self = $(this);

                // If already customized
                tidy(self);

                var node = this,
                    id = node.id,

                    // Layer styles
                    offset = -area + '%',
                    size = 100 + (area * 2) + '%',
                    layer = {
                        position: 'absolute',
                        top: offset,
                        left: offset,
                        display: 'block',
                        width: size,
                        height: size,
                        margin: 0,
                        padding: 0,
                        background: '#fff',
                        border: 0,
                        opacity: 0
                    },

                    // Choose how to hide input
                    hide = _mobile ? {
                        position: 'absolute',
                        visibility: 'hidden'
                    } : area ? layer : {
                        position: 'absolute',
                        opacity: 0
                    },

                    // Get proper class
                    className = node[_type] == _checkbox ? settings.checkboxClass || 'i' + _checkbox : settings.radioClass || 'i' + _radio,

                    // Find assigned labels
                    label = $(_label + '[for="' + id + '"]').add(self.closest(_label)),

                    // Check ARIA option
                    aria = !!settings.aria,

                    // Set ARIA placeholder
                    ariaID = _iCheck + '-' + Math.random().toString(36).substr(2,6),

                    // Parent & helper
                    parent = '<div class="' + className + '" ' + (aria ? 'role="' + node[_type] + '" ' : ''),
                    helper;

                // Set ARIA "labelledby"
                if (aria) {
                    label.each(function() {
                        parent += 'aria-labelledby="';

                        if (this.id) {
                            parent += this.id;
                        } else {
                            this.id = ariaID;
                            parent += ariaID;
                        }

                        parent += '"';
                    });
                }

                // Wrap input
                parent = self.wrap(parent + '/>')[_callback]('ifCreated').parent().append(settings.insert);

                // Layer addition
                helper = $('<ins class="' + _iCheckHelper + '"/>').css(layer).appendTo(parent);

                // Finalize customization
                self.data(_iCheck, {o: settings, s: self.attr('style')}).css(hide);
                !!settings.inheritClass && parent[_add](node.className || '');
                !!settings.inheritID && id && parent.attr('id', _iCheck + '-' + id);
                parent.css('position') == 'static' && parent.css('position', 'relative');
                operate(self, true, _update);

                // Label events
                if (label.length) {
                    label.on(_click + '.i mouseover.i mouseout.i ' + _touch, function(event) {
                        var type = event[_type],
                            item = $(this);

                        // Do nothing if input is disabled
                        if (!node[_disabled]) {

                            // Click
                            if (type == _click) {
                                if ($(event.target).is('a')) {
                                    return;
                                }
                                operate(self, false, true);

                                // Hover state
                            } else if (labelHover) {

                                // mouseout|touchend
                                if (/ut|nd/.test(type)) {
                                    parent[_remove](hoverClass);
                                    item[_remove](labelHoverClass);
                                } else {
                                    parent[_add](hoverClass);
                                    item[_add](labelHoverClass);
                                }
                            }

                            if (_mobile) {
                                event.stopPropagation();
                            } else {
                                return false;
                            }
                        }
                    });
                }

                // Input events
                self.on(_click + '.i focus.i blur.i keyup.i keydown.i keypress.i', function(event) {
                    var type = event[_type],
                        key = event.keyCode;

                    // Click
                    if (type == _click) {
                        return false;

                        // Keydown
                    } else if (type == 'keydown' && key == 32) {
                        if (!(node[_type] == _radio && node[_checked])) {
                            if (node[_checked]) {
                                off(self, _checked);
                            } else {
                                on(self, _checked);
                            }
                        }

                        return false;

                        // Keyup
                    } else if (type == 'keyup' && node[_type] == _radio) {
                        !node[_checked] && on(self, _checked);

                        // Focus/blur
                    } else if (/us|ur/.test(type)) {
                        parent[type == 'blur' ? _remove : _add](focusClass);
                    }
                });

                // Helper events
                helper.on(_click + ' mousedown mouseup mouseover mouseout ' + _touch, function(event) {
                    var type = event[_type],

                        // mousedown|mouseup
                        toggle = /wn|up/.test(type) ? activeClass : hoverClass;

                    // Do nothing if input is disabled
                    if (!node[_disabled]) {

                        // Click
                        if (type == _click) {
                            operate(self, false, true);

                            // Active and hover states
                        } else {

                            // State is on
                            if (/wn|er|in/.test(type)) {

                                // mousedown|mouseover|touchbegin
                                parent[_add](toggle);

                                // State is off
                            } else {
                                parent[_remove](toggle + ' ' + activeClass);
                            }

                            // Label hover
                            if (label.length && labelHover && toggle == hoverClass) {

                                // mouseout|touchend
                                label[/ut|nd/.test(type) ? _remove : _add](labelHoverClass);
                            }
                        }

                        if (_mobile) {
                            event.stopPropagation();
                        } else {
                            return false;
                        }
                    }
                });
            });
        } else {
            return this;
        }
    };

    // Do something with inputs
    function operate(input, direct, method) {
        var node = input[0],
            state = /er/.test(method) ? _indeterminate : /bl/.test(method) ? _disabled : _checked,
            active = method == _update ? {
                checked: node[_checked],
                disabled: node[_disabled],
                indeterminate: input.attr(_indeterminate) == 'true' || input.attr(_determinate) == 'false'
            } : node[state];

        // Check, disable or indeterminate
        if (/^(ch|di|in)/.test(method) && !active) {
            on(input, state);

            // Uncheck, enable or determinate
        } else if (/^(un|en|de)/.test(method) && active) {
            off(input, state);

            // Update
        } else if (method == _update) {

            // Handle states
            for (var each in active) {
                if (active[each]) {
                    on(input, each, true);
                } else {
                    off(input, each, true);
                }
            }

        } else if (!direct || method == 'toggle') {

            // Helper or label was clicked
            if (!direct) {
                input[_callback]('ifClicked');
            }

            // Toggle checked state
            if (active) {
                if (node[_type] !== _radio) {
                    off(input, state);
                }
            } else {
                on(input, state);
            }
        }
    }

    // Add checked, disabled or indeterminate state
    function on(input, state, keep) {
        var node = input[0],
            parent = input.parent(),
            checked = state == _checked,
            indeterminate = state == _indeterminate,
            disabled = state == _disabled,
            callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
            regular = option(input, callback + capitalize(node[_type])),
            specific = option(input, state + capitalize(node[_type]));

        // Prevent unnecessary actions
        if (node[state] !== true) {

            // Toggle assigned radio buttons
            if (!keep && state == _checked && node[_type] == _radio && node.name) {
                var form = input.closest('form'),
                    inputs = 'input[name="' + node.name + '"]';

                inputs = form.length ? form.find(inputs) : $(inputs);

                inputs.each(function() {
                    if (this !== node && $(this).data(_iCheck)) {
                        off($(this), state);
                    }
                });
            }

            // Indeterminate state
            if (indeterminate) {

                // Add indeterminate state
                node[state] = true;

                // Remove checked state
                if (node[_checked]) {
                    off(input, _checked, 'force');
                }

                // Checked or disabled state
            } else {

                // Add checked or disabled state
                if (!keep) {
                    node[state] = true;
                }

                // Remove indeterminate state
                if (checked && node[_indeterminate]) {
                    off(input, _indeterminate, false);
                }
            }

            // Trigger callbacks
            callbacks(input, checked, state, keep);
        }

        // Add proper cursor
        if (node[_disabled] && !!option(input, _cursor, true)) {
            parent.find('.' + _iCheckHelper).css(_cursor, 'default');
        }

        // Add state class
        parent[_add](specific || option(input, state) || '');

        // Set ARIA attribute
        if (!!parent.attr('role') && !indeterminate) {
            parent.attr('aria-' + (disabled ? _disabled : _checked), 'true');
        }

        // Remove regular state class
        parent[_remove](regular || option(input, callback) || '');
    }

    // Remove checked, disabled or indeterminate state
    function off(input, state, keep) {
        var node = input[0],
            parent = input.parent(),
            checked = state == _checked,
            indeterminate = state == _indeterminate,
            disabled = state == _disabled,
            callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
            regular = option(input, callback + capitalize(node[_type])),
            specific = option(input, state + capitalize(node[_type]));

        // Prevent unnecessary actions
        if (node[state] !== false) {

            // Toggle state
            if (indeterminate || !keep || keep == 'force') {
                node[state] = false;
            }

            // Trigger callbacks
            callbacks(input, checked, callback, keep);
        }

        // Add proper cursor
        if (!node[_disabled] && !!option(input, _cursor, true)) {
            parent.find('.' + _iCheckHelper).css(_cursor, 'pointer');
        }

        // Remove state class
        parent[_remove](specific || option(input, state) || '');

        // Set ARIA attribute
        if (!!parent.attr('role') && !indeterminate) {
            parent.attr('aria-' + (disabled ? _disabled : _checked), 'false');
        }

        // Add regular state class
        parent[_add](regular || option(input, callback) || '');
    }

    // Remove all traces
    function tidy(input, callback) {
        if (input.data(_iCheck)) {

            // Remove everything except input
            input.parent().html(input.attr('style', input.data(_iCheck).s || ''));

            // Callback
            if (callback) {
                input[_callback](callback);
            }

            // Unbind events
            input.off('.i').unwrap();
            $(_label + '[for="' + input[0].id + '"]').add(input.closest(_label)).off('.i');
        }
    }

    // Get some option
    function option(input, state, regular) {
        if (input.data(_iCheck)) {
            return input.data(_iCheck).o[state + (regular ? '' : 'Class')];
        }
    }

    // Capitalize some string
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Executable handlers
    function callbacks(input, checked, callback, keep) {
        if (!keep) {
            if (checked) {
                input[_callback]('ifToggled');
            }

            input[_callback]('ifChanged')[_callback]('if' + capitalize(callback));
        }
    }
})(window.jQuery || window.Zepto);


/**
 * microplugin.js
 * Copyright (c) 2013 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        define('microplugin', factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        root.MicroPlugin = factory();
    }
}(this, function() {
    var MicroPlugin = {};

    MicroPlugin.mixin = function(Interface) {
        Interface.plugins = {};

        /**
         * Initializes the listed plugins (with options).
         * Acceptable formats:
         *
         * List (without options):
         *   ['a', 'b', 'c']
         *
         * List (with options):
         *   [{'name': 'a', options: {}}, {'name': 'b', options: {}}]
         *
         * Hash (with options):
         *   {'a': { ... }, 'b': { ... }, 'c': { ... }}
         *
         * @param {mixed} plugins
         */
        Interface.prototype.initializePlugins = function(plugins) {
            var i, n, key;
            var self  = this;
            var queue = [];

            self.plugins = {
                names     : [],
                settings  : {},
                requested : {},
                loaded    : {}
            };

            if (utils.isArray(plugins)) {
                for (i = 0, n = plugins.length; i < n; i++) {
                    if (typeof plugins[i] === 'string') {
                        queue.push(plugins[i]);
                    } else {
                        self.plugins.settings[plugins[i].name] = plugins[i].options;
                        queue.push(plugins[i].name);
                    }
                }
            } else if (plugins) {
                for (key in plugins) {
                    if (plugins.hasOwnProperty(key)) {
                        self.plugins.settings[key] = plugins[key];
                        queue.push(key);
                    }
                }
            }

            while (queue.length) {
                self.require(queue.shift());
            }
        };

        Interface.prototype.loadPlugin = function(name) {
            var self    = this;
            var plugins = self.plugins;
            var plugin  = Interface.plugins[name];

            if (!Interface.plugins.hasOwnProperty(name)) {
                throw new Error('Unable to find "' +  name + '" plugin');
            }

            plugins.requested[name] = true;
            plugins.loaded[name] = plugin.fn.apply(self, [self.plugins.settings[name] || {}]);
            plugins.names.push(name);
        };

        /**
         * Initializes a plugin.
         *
         * @param {string} name
         */
        Interface.prototype.require = function(name) {
            var self = this;
            var plugins = self.plugins;

            if (!self.plugins.loaded.hasOwnProperty(name)) {
                if (plugins.requested[name]) {
                    throw new Error('Plugin has circular dependency ("' + name + '")');
                }
                self.loadPlugin(name);
            }

            return plugins.loaded[name];
        };

        /**
         * Registers a plugin.
         *
         * @param {string} name
         * @param {function} fn
         */
        Interface.define = function(name, fn) {
            Interface.plugins[name] = {
                'name' : name,
                'fn'   : fn
            };
        };
    };

    var utils = {
        isArray: Array.isArray || function(vArg) {
            return Object.prototype.toString.call(vArg) === '[object Array]';
        }
    };

    return MicroPlugin;
}));

/**
 * selectize.js (v0.12.4)
 * Copyright (c) 2013–2015 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

/*jshint curly:false */
/*jshint browser:true */

(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        define('selectize', ['jquery','sifter','microplugin'], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory(require('jquery'), require('sifter'), require('microplugin'));
    } else {
        root.Selectize = factory(root.jQuery, root.Sifter, root.MicroPlugin);
    }
}(this, function($, Sifter, MicroPlugin) {
    'use strict';

    var highlight = function($element, pattern) {
        if (typeof pattern === 'string' && !pattern.length) return;
        var regex = (typeof pattern === 'string') ? new RegExp(pattern, 'i') : pattern;

        var highlight = function(node) {
            var skip = 0;
            if (node.nodeType === 3) {
                var pos = node.data.search(regex);
                if (pos >= 0 && node.data.length > 0) {
                    var match = node.data.match(regex);
                    var spannode = document.createElement('span');
                    spannode.className = 'highlight';
                    var middlebit = node.splitText(pos);
                    var endbit = middlebit.splitText(match[0].length);
                    var middleclone = middlebit.cloneNode(true);
                    spannode.appendChild(middleclone);
                    middlebit.parentNode.replaceChild(spannode, middlebit);
                    skip = 1;
                }
            } else if (node.nodeType === 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
                for (var i = 0; i < node.childNodes.length; ++i) {
                    i += highlight(node.childNodes[i]);
                }
            }
            return skip;
        };

        return $element.each(function() {
            highlight(this);
        });
    };

    /**
     * removeHighlight fn copied from highlight v5 and
     * edited to remove with() and pass js strict mode
     */
    $.fn.removeHighlight = function() {
        return this.find("span.highlight").each(function() {
            this.parentNode.firstChild.nodeName;
            var parent = this.parentNode;
            parent.replaceChild(this.firstChild, this);
            parent.normalize();
        }).end();
    };


    var MicroEvent = function() {};
    MicroEvent.prototype = {
        on: function(event, fct){
            this._events = this._events || {};
            this._events[event] = this._events[event] || [];
            this._events[event].push(fct);
        },
        off: function(event, fct){
            var n = arguments.length;
            if (n === 0) return delete this._events;
            if (n === 1) return delete this._events[event];

            this._events = this._events || {};
            if (event in this._events === false) return;
            this._events[event].splice(this._events[event].indexOf(fct), 1);
        },
        trigger: function(event /* , args... */){
            this._events = this._events || {};
            if (event in this._events === false) return;
            for (var i = 0; i < this._events[event].length; i++){
                this._events[event][i].apply(this, Array.prototype.slice.call(arguments, 1));
            }
        }
    };

    /**
     * Mixin will delegate all MicroEvent.js function in the destination object.
     *
     * - MicroEvent.mixin(Foobar) will make Foobar able to use MicroEvent
     *
     * @param {object} the object which will support MicroEvent
     */
    MicroEvent.mixin = function(destObject){
        var props = ['on', 'off', 'trigger'];
        for (var i = 0; i < props.length; i++){
            destObject.prototype[props[i]] = MicroEvent.prototype[props[i]];
        }
    };

    var IS_MAC        = /Mac/.test(navigator.userAgent);

    var KEY_A         = 65;
    var KEY_COMMA     = 188;
    var KEY_RETURN    = 13;
    var KEY_ESC       = 27;
    var KEY_LEFT      = 37;
    var KEY_UP        = 38;
    var KEY_P         = 80;
    var KEY_RIGHT     = 39;
    var KEY_DOWN      = 40;
    var KEY_N         = 78;
    var KEY_BACKSPACE = 8;
    var KEY_DELETE    = 46;
    var KEY_SHIFT     = 16;
    var KEY_CMD       = IS_MAC ? 91 : 17;
    var KEY_CTRL      = IS_MAC ? 18 : 17;
    var KEY_TAB       = 9;

    var TAG_SELECT    = 1;
    var TAG_INPUT     = 2;

    // for now, android support in general is too spotty to support validity
    var SUPPORTS_VALIDITY_API = !/android/i.test(window.navigator.userAgent) && !!document.createElement('input').validity;


    var isset = function(object) {
        return typeof object !== 'undefined';
    };

    /**
     * Converts a scalar to its best string representation
     * for hash keys and HTML attribute values.
     *
     * Transformations:
     *   'str'     -> 'str'
     *   null      -> ''
     *   undefined -> ''
     *   true      -> '1'
     *   false     -> '0'
     *   0         -> '0'
     *   1         -> '1'
     *
     * @param {string} value
     * @returns {string|null}
     */
    var hash_key = function(value) {
        if (typeof value === 'undefined' || value === null) return null;
        if (typeof value === 'boolean') return value ? '1' : '0';
        return value + '';
    };

    /**
     * Escapes a string for use within HTML.
     *
     * @param {string} str
     * @returns {string}
     */
    var escape_html = function(str) {
        return (str + '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    };

    /**
     * Escapes "$" characters in replacement strings.
     *
     * @param {string} str
     * @returns {string}
     */
    var escape_replace = function(str) {
        return (str + '').replace(/\$/g, '$$$$');
    };

    var hook = {};

    /**
     * Wraps `method` on `self` so that `fn`
     * is invoked before the original method.
     *
     * @param {object} self
     * @param {string} method
     * @param {function} fn
     */
    hook.before = function(self, method, fn) {
        var original = self[method];
        self[method] = function() {
            fn.apply(self, arguments);
            return original.apply(self, arguments);
        };
    };

    /**
     * Wraps `method` on `self` so that `fn`
     * is invoked after the original method.
     *
     * @param {object} self
     * @param {string} method
     * @param {function} fn
     */
    hook.after = function(self, method, fn) {
        var original = self[method];
        self[method] = function() {
            var result = original.apply(self, arguments);
            fn.apply(self, arguments);
            return result;
        };
    };

    /**
     * Wraps `fn` so that it can only be invoked once.
     *
     * @param {function} fn
     * @returns {function}
     */
    var once = function(fn) {
        var called = false;
        return function() {
            if (called) return;
            called = true;
            fn.apply(this, arguments);
        };
    };

    /**
     * Wraps `fn` so that it can only be called once
     * every `delay` milliseconds (invoked on the falling edge).
     *
     * @param {function} fn
     * @param {int} delay
     * @returns {function}
     */
    var debounce = function(fn, delay) {
        var timeout;
        return function() {
            var self = this;
            var args = arguments;
            window.clearTimeout(timeout);
            timeout = window.setTimeout(function() {
                fn.apply(self, args);
            }, delay);
        };
    };

    /**
     * Debounce all fired events types listed in `types`
     * while executing the provided `fn`.
     *
     * @param {object} self
     * @param {array} types
     * @param {function} fn
     */
    var debounce_events = function(self, types, fn) {
        var type;
        var trigger = self.trigger;
        var event_args = {};

        // override trigger method
        self.trigger = function() {
            var type = arguments[0];
            if (types.indexOf(type) !== -1) {
                event_args[type] = arguments;
            } else {
                return trigger.apply(self, arguments);
            }
        };

        // invoke provided function
        fn.apply(self, []);
        self.trigger = trigger;

        // trigger queued events
        for (type in event_args) {
            if (event_args.hasOwnProperty(type)) {
                trigger.apply(self, event_args[type]);
            }
        }
    };

    /**
     * A workaround for http://bugs.jquery.com/ticket/6696
     *
     * @param {object} $parent - Parent element to listen on.
     * @param {string} event - Event name.
     * @param {string} selector - Descendant selector to filter by.
     * @param {function} fn - Event handler.
     */
    var watchChildEvent = function($parent, event, selector, fn) {
        $parent.on(event, selector, function(e) {
            var child = e.target;
            while (child && child.parentNode !== $parent[0]) {
                child = child.parentNode;
            }
            e.currentTarget = child;
            return fn.apply(this, [e]);
        });
    };

    /**
     * Determines the current selection within a text input control.
     * Returns an object containing:
     *   - start
     *   - length
     *
     * @param {object} input
     * @returns {object}
     */
    var getSelection = function(input) {
        var result = {};
        if ('selectionStart' in input) {
            result.start = input.selectionStart;
            result.length = input.selectionEnd - result.start;
        } else if (document.selection) {
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            result.start = sel.text.length - selLen;
            result.length = selLen;
        }
        return result;
    };

    /**
     * Copies CSS properties from one element to another.
     *
     * @param {object} $from
     * @param {object} $to
     * @param {array} properties
     */
    var transferStyles = function($from, $to, properties) {
        var i, n, styles = {};
        if (properties) {
            for (i = 0, n = properties.length; i < n; i++) {
                styles[properties[i]] = $from.css(properties[i]);
            }
        } else {
            styles = $from.css();
        }
        $to.css(styles);
    };

    /**
     * Measures the width of a string within a
     * parent element (in pixels).
     *
     * @param {string} str
     * @param {object} $parent
     * @returns {int}
     */
    var measureString = function(str, $parent) {
        if (!str) {
            return 0;
        }

        var $test = $('<test>').css({
            position: 'absolute',
            top: -99999,
            left: -99999,
            width: 'auto',
            padding: 0,
            whiteSpace: 'pre'
        }).text(str).appendTo('body');

        transferStyles($parent, $test, [
            'letterSpacing',
            'fontSize',
            'fontFamily',
            'fontWeight',
            'textTransform'
        ]);

        var width = $test.width();
        $test.remove();

        return width;
    };

    /**
     * Sets up an input to grow horizontally as the user
     * types. If the value is changed manually, you can
     * trigger the "update" handler to resize:
     *
     * $input.trigger('update');
     *
     * @param {object} $input
     */
    var autoGrow = function($input) {
        var currentWidth = null;

        var update = function(e, options) {
            var value, keyCode, printable, placeholder, width;
            var shift, character, selection;
            e = e || window.event || {};
            options = options || {};

            if (e.metaKey || e.altKey) return;
            if (!options.force && $input.data('grow') === false) return;

            value = $input.val();
            if (e.type && e.type.toLowerCase() === 'keydown') {
                keyCode = e.keyCode;
                printable = (
                    (keyCode >= 97 && keyCode <= 122) || // a-z
                    (keyCode >= 65 && keyCode <= 90)  || // A-Z
                    (keyCode >= 48 && keyCode <= 57)  || // 0-9
                    keyCode === 32 // space
                );

                if (keyCode === KEY_DELETE || keyCode === KEY_BACKSPACE) {
                    selection = getSelection($input[0]);
                    if (selection.length) {
                        value = value.substring(0, selection.start) + value.substring(selection.start + selection.length);
                    } else if (keyCode === KEY_BACKSPACE && selection.start) {
                        value = value.substring(0, selection.start - 1) + value.substring(selection.start + 1);
                    } else if (keyCode === KEY_DELETE && typeof selection.start !== 'undefined') {
                        value = value.substring(0, selection.start) + value.substring(selection.start + 1);
                    }
                } else if (printable) {
                    shift = e.shiftKey;
                    character = String.fromCharCode(e.keyCode);
                    if (shift) character = character.toUpperCase();
                    else character = character.toLowerCase();
                    value += character;
                }
            }

            placeholder = $input.attr('placeholder');
            if (!value && placeholder) {
                value = placeholder;
            }

            width = measureString(value, $input) + 4;
            if (width !== currentWidth) {
                currentWidth = width;
                $input.width(width);
                $input.triggerHandler('resize');
            }
        };

        $input.on('keydown keyup update blur', update);
        update();
    };

    var domToString = function(d) {
        var tmp = document.createElement('div');

        tmp.appendChild(d.cloneNode(true));

        return tmp.innerHTML;
    };

    var logError = function(message, options){
        if(!options) options = {};
        var component = "Selectize";

        console.error(component + ": " + message)

        if(options.explanation){
            // console.group is undefined in <IE11
            if(console.group) console.group();
            console.error(options.explanation);
            if(console.group) console.groupEnd();
        }
    }


    var Selectize = function($input, settings) {
        var key, i, n, dir, input, self = this;
        input = $input[0];
        input.selectize = self;

        // detect rtl environment
        var computedStyle = window.getComputedStyle && window.getComputedStyle(input, null);
        dir = computedStyle ? computedStyle.getPropertyValue('direction') : input.currentStyle && input.currentStyle.direction;
        dir = dir || $input.parents('[dir]:first').attr('dir') || '';

        // setup default state
        $.extend(self, {
            order            : 0,
            settings         : settings,
            $input           : $input,
            tabIndex         : $input.attr('tabindex') || '',
            tagType          : input.tagName.toLowerCase() === 'select' ? TAG_SELECT : TAG_INPUT,
            rtl              : /rtl/i.test(dir),

            eventNS          : '.selectize' + (++Selectize.count),
            highlightedValue : null,
            isOpen           : false,
            isDisabled       : false,
            isRequired       : $input.is('[required]'),
            isInvalid        : false,
            isLocked         : false,
            isFocused        : false,
            isInputHidden    : false,
            isSetup          : false,
            isShiftDown      : false,
            isCmdDown        : false,
            isCtrlDown       : false,
            ignoreFocus      : false,
            ignoreBlur       : false,
            ignoreHover      : false,
            hasOptions       : false,
            currentResults   : null,
            lastValue        : '',
            caretPos         : 0,
            loading          : 0,
            loadedSearches   : {},

            $activeOption    : null,
            $activeItems     : [],

            optgroups        : {},
            options          : {},
            userOptions      : {},
            items            : [],
            renderCache      : {},
            onSearchChange   : settings.loadThrottle === null ? self.onSearchChange : debounce(self.onSearchChange, settings.loadThrottle)
        });

        // search system
        self.sifter = new Sifter(this.options, {diacritics: settings.diacritics});

        // build options table
        if (self.settings.options) {
            for (i = 0, n = self.settings.options.length; i < n; i++) {
                self.registerOption(self.settings.options[i]);
            }
            delete self.settings.options;
        }

        // build optgroup table
        if (self.settings.optgroups) {
            for (i = 0, n = self.settings.optgroups.length; i < n; i++) {
                self.registerOptionGroup(self.settings.optgroups[i]);
            }
            delete self.settings.optgroups;
        }

        // option-dependent defaults
        self.settings.mode = self.settings.mode || (self.settings.maxItems === 1 ? 'single' : 'multi');
        if (typeof self.settings.hideSelected !== 'boolean') {
            self.settings.hideSelected = self.settings.mode === 'multi';
        }

        self.initializePlugins(self.settings.plugins);
        self.setupCallbacks();
        self.setupTemplates();
        self.setup();
    };

    // mixins
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    MicroEvent.mixin(Selectize);

    if(typeof MicroPlugin !== "undefined"){
        MicroPlugin.mixin(Selectize);
    }else{
        logError("Dependency MicroPlugin is missing",
            {explanation:
                    "Make sure you either: (1) are using the \"standalone\" "+
                    "version of Selectize, or (2) require MicroPlugin before you "+
                    "load Selectize."}
        );
    }


    // methods
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $.extend(Selectize.prototype, {

        /**
         * Creates all elements and sets up event bindings.
         */
        setup: function() {
            var self      = this;
            var settings  = self.settings;
            var eventNS   = self.eventNS;
            var $window   = $(window);
            var $document = $(document);
            var $input    = self.$input;

            var $wrapper;
            var $control;
            var $control_input;
            var $dropdown;
            var $dropdown_content;
            var $dropdown_parent;
            var inputMode;
            var timeout_blur;
            var timeout_focus;
            var classes;
            var classes_plugins;
            var inputId;

            inputMode         = self.settings.mode;
            classes           = $input.attr('class') || '';

            $wrapper          = $('<div>').addClass(settings.wrapperClass).addClass(classes).addClass(inputMode);
            $control          = $('<div>').addClass(settings.inputClass).addClass('items').appendTo($wrapper);
            $control_input    = $('<input type="text" autocomplete="off" />').appendTo($control).attr('tabindex', $input.is(':disabled') ? '-1' : self.tabIndex);
            $dropdown_parent  = $(settings.dropdownParent || $wrapper);
            $dropdown         = $('<div>').addClass(settings.dropdownClass).addClass(inputMode).hide().appendTo($dropdown_parent);
            $dropdown_content = $('<div>').addClass(settings.dropdownContentClass).appendTo($dropdown);

            if(inputId = $input.attr('id')) {
                $control_input.attr('id', inputId + '-selectized');
                $("label[for='"+inputId+"']").attr('for', inputId + '-selectized');
            }

            if(self.settings.copyClassesToDropdown) {
                $dropdown.addClass(classes);
            }

            $wrapper.css({
                width: $input[0].style.width
            });

            if (self.plugins.names.length) {
                classes_plugins = 'plugin-' + self.plugins.names.join(' plugin-');
                $wrapper.addClass(classes_plugins);
                $dropdown.addClass(classes_plugins);
            }

            if ((settings.maxItems === null || settings.maxItems > 1) && self.tagType === TAG_SELECT) {
                $input.attr('multiple', 'multiple');
            }

            if (self.settings.placeholder) {
                $control_input.attr('placeholder', settings.placeholder);
            }

            // if splitOn was not passed in, construct it from the delimiter to allow pasting universally
            if (!self.settings.splitOn && self.settings.delimiter) {
                var delimiterEscaped = self.settings.delimiter.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                self.settings.splitOn = new RegExp('\\s*' + delimiterEscaped + '+\\s*');
            }

            if ($input.attr('autocorrect')) {
                $control_input.attr('autocorrect', $input.attr('autocorrect'));
            }

            if ($input.attr('autocapitalize')) {
                $control_input.attr('autocapitalize', $input.attr('autocapitalize'));
            }

            self.$wrapper          = $wrapper;
            self.$control          = $control;
            self.$control_input    = $control_input;
            self.$dropdown         = $dropdown;
            self.$dropdown_content = $dropdown_content;

            $dropdown.on('mouseenter', '[data-selectable]', function() { return self.onOptionHover.apply(self, arguments); });
            $dropdown.on('mousedown click', '[data-selectable]', function() { return self.onOptionSelect.apply(self, arguments); });
            watchChildEvent($control, 'mousedown', '*:not(input)', function() { return self.onItemSelect.apply(self, arguments); });
            autoGrow($control_input);

            $control.on({
                mousedown : function() { return self.onMouseDown.apply(self, arguments); },
                click     : function() { return self.onClick.apply(self, arguments); }
            });

            $control_input.on({
                mousedown : function(e) { e.stopPropagation(); },
                keydown   : function() { return self.onKeyDown.apply(self, arguments); },
                keyup     : function() { return self.onKeyUp.apply(self, arguments); },
                keypress  : function() { return self.onKeyPress.apply(self, arguments); },
                resize    : function() { self.positionDropdown.apply(self, []); },
                blur      : function() { return self.onBlur.apply(self, arguments); },
                focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
                paste     : function() { return self.onPaste.apply(self, arguments); }
            });

            $document.on('keydown' + eventNS, function(e) {
                self.isCmdDown = e[IS_MAC ? 'metaKey' : 'ctrlKey'];
                self.isCtrlDown = e[IS_MAC ? 'altKey' : 'ctrlKey'];
                self.isShiftDown = e.shiftKey;
            });

            $document.on('keyup' + eventNS, function(e) {
                if (e.keyCode === KEY_CTRL) self.isCtrlDown = false;
                if (e.keyCode === KEY_SHIFT) self.isShiftDown = false;
                if (e.keyCode === KEY_CMD) self.isCmdDown = false;
            });

            $document.on('mousedown' + eventNS, function(e) {
                if (self.isFocused) {
                    // prevent events on the dropdown scrollbar from causing the control to blur
                    if (e.target === self.$dropdown[0] || e.target.parentNode === self.$dropdown[0]) {
                        return false;
                    }
                    // blur on click outside
                    if (!self.$control.has(e.target).length && e.target !== self.$control[0]) {
                        self.blur(e.target);
                    }
                }
            });

            $window.on(['scroll' + eventNS, 'resize' + eventNS].join(' '), function() {
                if (self.isOpen) {
                    self.positionDropdown.apply(self, arguments);
                }
            });
            $window.on('mousemove' + eventNS, function() {
                self.ignoreHover = false;
            });

            // store original children and tab index so that they can be
            // restored when the destroy() method is called.
            this.revertSettings = {
                $children : $input.children().detach(),
                tabindex  : $input.attr('tabindex')
            };

            $input.attr('tabindex', -1).hide().after(self.$wrapper);

            if ($.isArray(settings.items)) {
                self.setValue(settings.items);
                delete settings.items;
            }

            // feature detect for the validation API
            if (SUPPORTS_VALIDITY_API) {
                $input.on('invalid' + eventNS, function(e) {
                    e.preventDefault();
                    self.isInvalid = true;
                    self.refreshState();
                });
            }

            self.updateOriginalInput();
            self.refreshItems();
            self.refreshState();
            self.updatePlaceholder();
            self.isSetup = true;

            if ($input.is(':disabled')) {
                self.disable();
            }

            self.on('change', this.onChange);

            $input.data('selectize', self);
            $input.addClass('selectized');
            self.trigger('initialize');

            // preload options
            if (settings.preload === true) {
                self.onSearchChange('');
            }

        },

        /**
         * Sets up default rendering functions.
         */
        setupTemplates: function() {
            var self = this;
            var field_label = self.settings.labelField;
            var field_optgroup = self.settings.optgroupLabelField;

            var templates = {
                'optgroup': function(data) {
                    return '<div class="optgroup">' + data.html + '</div>';
                },
                'optgroup_header': function(data, escape) {
                    return '<div class="optgroup-header">' + escape(data[field_optgroup]) + '</div>';
                },
                'option': function(data, escape) {
                    return '<div class="option">' + escape(data[field_label]) + '</div>';
                },
                'item': function(data, escape) {
                    return '<div class="item">' + escape(data[field_label]) + '</div>';
                },
                'option_create': function(data, escape) {
                    return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                }
            };

            self.settings.render = $.extend({}, templates, self.settings.render);
        },

        /**
         * Maps fired events to callbacks provided
         * in the settings used when creating the control.
         */
        setupCallbacks: function() {
            var key, fn, callbacks = {
                'initialize'      : 'onInitialize',
                'change'          : 'onChange',
                'item_add'        : 'onItemAdd',
                'item_remove'     : 'onItemRemove',
                'clear'           : 'onClear',
                'option_add'      : 'onOptionAdd',
                'option_remove'   : 'onOptionRemove',
                'option_clear'    : 'onOptionClear',
                'optgroup_add'    : 'onOptionGroupAdd',
                'optgroup_remove' : 'onOptionGroupRemove',
                'optgroup_clear'  : 'onOptionGroupClear',
                'dropdown_open'   : 'onDropdownOpen',
                'dropdown_close'  : 'onDropdownClose',
                'type'            : 'onType',
                'load'            : 'onLoad',
                'focus'           : 'onFocus',
                'blur'            : 'onBlur'
            };

            for (key in callbacks) {
                if (callbacks.hasOwnProperty(key)) {
                    fn = this.settings[callbacks[key]];
                    if (fn) this.on(key, fn);
                }
            }
        },

        /**
         * Triggered when the main control element
         * has a click event.
         *
         * @param {object} e
         * @return {boolean}
         */
        onClick: function(e) {
            var self = this;

            // necessary for mobile webkit devices (manual focus triggering
            // is ignored unless invoked within a click event)
            if (!self.isFocused) {
                self.focus();
                e.preventDefault();
            }
        },

        /**
         * Triggered when the main control element
         * has a mouse down event.
         *
         * @param {object} e
         * @return {boolean}
         */
        onMouseDown: function(e) {
            var self = this;
            var defaultPrevented = e.isDefaultPrevented();
            var $target = $(e.target);

            if (self.isFocused) {
                // retain focus by preventing native handling. if the
                // event target is the input it should not be modified.
                // otherwise, text selection within the input won't work.
                if (e.target !== self.$control_input[0]) {
                    if (self.settings.mode === 'single') {
                        // toggle dropdown
                        self.isOpen ? self.close() : self.open();
                    } else if (!defaultPrevented) {
                        self.setActiveItem(null);
                    }
                    return false;
                }
            } else {
                // give control focus
                if (!defaultPrevented) {
                    window.setTimeout(function() {
                        self.focus();
                    }, 0);
                }
            }
        },

        /**
         * Triggered when the value of the control has been changed.
         * This should propagate the event to the original DOM
         * input / select element.
         */
        onChange: function() {
            this.$input.trigger('change');
        },

        /**
         * Triggered on <input> paste.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onPaste: function(e) {
            var self = this;

            if (self.isFull() || self.isInputHidden || self.isLocked) {
                e.preventDefault();
                return;
            }

            // If a regex or string is included, this will split the pasted
            // input and create Items for each separate value
            if (self.settings.splitOn) {

                // Wait for pasted text to be recognized in value
                setTimeout(function() {
                    var pastedText = self.$control_input.val();
                    if(!pastedText.match(self.settings.splitOn)){ return }

                    var splitInput = $.trim(pastedText).split(self.settings.splitOn);
                    for (var i = 0, n = splitInput.length; i < n; i++) {
                        self.createItem(splitInput[i]);
                    }
                }, 0);
            }
        },

        /**
         * Triggered on <input> keypress.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onKeyPress: function(e) {
            if (this.isLocked) return e && e.preventDefault();
            var character = String.fromCharCode(e.keyCode || e.which);
            if (this.settings.create && this.settings.mode === 'multi' && character === this.settings.delimiter) {
                this.createItem();
                e.preventDefault();
                return false;
            }
        },

        /**
         * Triggered on <input> keydown.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onKeyDown: function(e) {
            var isInput = e.target === this.$control_input[0];
            var self = this;

            if (self.isLocked) {
                if (e.keyCode !== KEY_TAB) {
                    e.preventDefault();
                }
                return;
            }

            switch (e.keyCode) {
                case KEY_A:
                    if (self.isCmdDown) {
                        self.selectAll();
                        return;
                    }
                    break;
                case KEY_ESC:
                    if (self.isOpen) {
                        e.preventDefault();
                        e.stopPropagation();
                        self.close();
                    }
                    return;
                case KEY_N:
                    if (!e.ctrlKey || e.altKey) break;
                case KEY_DOWN:
                    if (!self.isOpen && self.hasOptions) {
                        self.open();
                    } else if (self.$activeOption) {
                        self.ignoreHover = true;
                        var $next = self.getAdjacentOption(self.$activeOption, 1);
                        if ($next.length) self.setActiveOption($next, true, true);
                    }
                    e.preventDefault();
                    return;
                case KEY_P:
                    if (!e.ctrlKey || e.altKey) break;
                case KEY_UP:
                    if (self.$activeOption) {
                        self.ignoreHover = true;
                        var $prev = self.getAdjacentOption(self.$activeOption, -1);
                        if ($prev.length) self.setActiveOption($prev, true, true);
                    }
                    e.preventDefault();
                    return;
                case KEY_RETURN:
                    if (self.isOpen && self.$activeOption) {
                        self.onOptionSelect({currentTarget: self.$activeOption});
                        e.preventDefault();
                    }
                    return;
                case KEY_LEFT:
                    self.advanceSelection(-1, e);
                    return;
                case KEY_RIGHT:
                    self.advanceSelection(1, e);
                    return;
                case KEY_TAB:
                    if (self.settings.selectOnTab && self.isOpen && self.$activeOption) {
                        self.onOptionSelect({currentTarget: self.$activeOption});

                        // Default behaviour is to jump to the next field, we only want this
                        // if the current field doesn't accept any more entries
                        if (!self.isFull()) {
                            e.preventDefault();
                        }
                    }
                    if (self.settings.create && self.createItem()) {
                        e.preventDefault();
                    }
                    return;
                case KEY_BACKSPACE:
                case KEY_DELETE:
                    self.deleteSelection(e);
                    return;
            }

            if ((self.isFull() || self.isInputHidden) && !(IS_MAC ? e.metaKey : e.ctrlKey)) {
                e.preventDefault();
                return;
            }
        },

        /**
         * Triggered on <input> keyup.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onKeyUp: function(e) {
            var self = this;

            if (self.isLocked) return e && e.preventDefault();
            var value = self.$control_input.val() || '';
            if (self.lastValue !== value) {
                self.lastValue = value;
                self.onSearchChange(value);
                self.refreshOptions();
                self.trigger('type', value);
            }
        },

        /**
         * Invokes the user-provide option provider / loader.
         *
         * Note: this function is debounced in the Selectize
         * constructor (by `settings.loadThrottle` milliseconds)
         *
         * @param {string} value
         */
        onSearchChange: function(value) {
            var self = this;
            var fn = self.settings.load;
            if (!fn) return;
            if (self.loadedSearches.hasOwnProperty(value)) return;
            self.loadedSearches[value] = true;
            self.load(function(callback) {
                fn.apply(self, [value, callback]);
            });
        },

        /**
         * Triggered on <input> focus.
         *
         * @param {object} e (optional)
         * @returns {boolean}
         */
        onFocus: function(e) {
            var self = this;
            var wasFocused = self.isFocused;

            if (self.isDisabled) {
                self.blur();
                e && e.preventDefault();
                return false;
            }

            if (self.ignoreFocus) return;
            self.isFocused = true;
            if (self.settings.preload === 'focus') self.onSearchChange('');

            if (!wasFocused) self.trigger('focus');

            if (!self.$activeItems.length) {
                self.showInput();
                self.setActiveItem(null);
                self.refreshOptions(!!self.settings.openOnFocus);
            }

            self.refreshState();
        },

        /**
         * Triggered on <input> blur.
         *
         * @param {object} e
         * @param {Element} dest
         */
        onBlur: function(e, dest) {
            var self = this;
            if (!self.isFocused) return;
            self.isFocused = false;

            if (self.ignoreFocus) {
                return;
            } else if (!self.ignoreBlur && document.activeElement === self.$dropdown_content[0]) {
                // necessary to prevent IE closing the dropdown when the scrollbar is clicked
                self.ignoreBlur = true;
                self.onFocus(e);
                return;
            }

            var deactivate = function() {
                self.close();
                self.setTextboxValue('');
                self.setActiveItem(null);
                self.setActiveOption(null);
                self.setCaret(self.items.length);
                self.refreshState();

                // IE11 bug: element still marked as active
                dest && dest.focus && dest.focus();

                self.ignoreFocus = false;
                self.trigger('blur');
            };

            self.ignoreFocus = true;
            if (self.settings.create && self.settings.createOnBlur) {
                self.createItem(null, false, deactivate);
            } else {
                deactivate();
            }
        },

        /**
         * Triggered when the user rolls over
         * an option in the autocomplete dropdown menu.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onOptionHover: function(e) {
            if (this.ignoreHover) return;
            this.setActiveOption(e.currentTarget, false);
        },

        /**
         * Triggered when the user clicks on an option
         * in the autocomplete dropdown menu.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onOptionSelect: function(e) {
            var value, $target, $option, self = this;

            if (e.preventDefault) {
                e.preventDefault();
                e.stopPropagation();
            }

            $target = $(e.currentTarget);
            if ($target.hasClass('create')) {
                self.createItem(null, function() {
                    if (self.settings.closeAfterSelect) {
                        self.close();
                    }
                });
            } else {
                value = $target.attr('data-value');
                if (typeof value !== 'undefined') {
                    self.lastQuery = null;
                    self.setTextboxValue('');
                    self.addItem(value);
                    if (self.settings.closeAfterSelect) {
                        self.close();
                    } else if (!self.settings.hideSelected && e.type && /mouse/.test(e.type)) {
                        self.setActiveOption(self.getOption(value));
                    }
                }
            }
        },

        /**
         * Triggered when the user clicks on an item
         * that has been selected.
         *
         * @param {object} e
         * @returns {boolean}
         */
        onItemSelect: function(e) {
            var self = this;

            if (self.isLocked) return;
            if (self.settings.mode === 'multi') {
                e.preventDefault();
                self.setActiveItem(e.currentTarget, e);
            }
        },

        /**
         * Invokes the provided method that provides
         * results to a callback---which are then added
         * as options to the control.
         *
         * @param {function} fn
         */
        load: function(fn) {
            var self = this;
            var $wrapper = self.$wrapper.addClass(self.settings.loadingClass);

            self.loading++;
            fn.apply(self, [function(results) {
                self.loading = Math.max(self.loading - 1, 0);
                if (results && results.length) {
                    self.addOption(results);
                    self.refreshOptions(self.isFocused && !self.isInputHidden);
                }
                if (!self.loading) {
                    $wrapper.removeClass(self.settings.loadingClass);
                }
                self.trigger('load', results);
            }]);
        },

        /**
         * Sets the input field of the control to the specified value.
         *
         * @param {string} value
         */
        setTextboxValue: function(value) {
            var $input = this.$control_input;
            var changed = $input.val() !== value;
            if (changed) {
                $input.val(value).triggerHandler('update');
                this.lastValue = value;
            }
        },

        /**
         * Returns the value of the control. If multiple items
         * can be selected (e.g. <select multiple>), this returns
         * an array. If only one item can be selected, this
         * returns a string.
         *
         * @returns {mixed}
         */
        getValue: function() {
            if (this.tagType === TAG_SELECT && this.$input.attr('multiple')) {
                return this.items;
            } else {
                return this.items.join(this.settings.delimiter);
            }
        },

        /**
         * Resets the selected items to the given value.
         *
         * @param {mixed} value
         */
        setValue: function(value, silent) {
            var events = silent ? [] : ['change'];

            debounce_events(this, events, function() {
                this.clear(silent);
                this.addItems(value, silent);
            });
        },

        /**
         * Sets the selected item.
         *
         * @param {object} $item
         * @param {object} e (optional)
         */
        setActiveItem: function($item, e) {
            var self = this;
            var eventName;
            var i, idx, begin, end, item, swap;
            var $last;

            if (self.settings.mode === 'single') return;
            $item = $($item);

            // clear the active selection
            if (!$item.length) {
                $(self.$activeItems).removeClass('active');
                self.$activeItems = [];
                if (self.isFocused) {
                    self.showInput();
                }
                return;
            }

            // modify selection
            eventName = e && e.type.toLowerCase();

            if (eventName === 'mousedown' && self.isShiftDown && self.$activeItems.length) {
                $last = self.$control.children('.active:last');
                begin = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$last[0]]);
                end   = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$item[0]]);
                if (begin > end) {
                    swap  = begin;
                    begin = end;
                    end   = swap;
                }
                for (i = begin; i <= end; i++) {
                    item = self.$control[0].childNodes[i];
                    if (self.$activeItems.indexOf(item) === -1) {
                        $(item).addClass('active');
                        self.$activeItems.push(item);
                    }
                }
                e.preventDefault();
            } else if ((eventName === 'mousedown' && self.isCtrlDown) || (eventName === 'keydown' && this.isShiftDown)) {
                if ($item.hasClass('active')) {
                    idx = self.$activeItems.indexOf($item[0]);
                    self.$activeItems.splice(idx, 1);
                    $item.removeClass('active');
                } else {
                    self.$activeItems.push($item.addClass('active')[0]);
                }
            } else {
                $(self.$activeItems).removeClass('active');
                self.$activeItems = [$item.addClass('active')[0]];
            }

            // ensure control has focus
            self.hideInput();
            if (!this.isFocused) {
                self.focus();
            }
        },

        /**
         * Sets the selected item in the dropdown menu
         * of available options.
         *
         * @param {object} $object
         * @param {boolean} scroll
         * @param {boolean} animate
         */
        setActiveOption: function($option, scroll, animate) {
            var height_menu, height_item, y;
            var scroll_top, scroll_bottom;
            var self = this;

            if (self.$activeOption) self.$activeOption.removeClass('active');
            self.$activeOption = null;

            $option = $($option);
            if (!$option.length) return;

            self.$activeOption = $option.addClass('active');

            if (scroll || !isset(scroll)) {

                height_menu   = self.$dropdown_content.height();
                height_item   = self.$activeOption.outerHeight(true);
                scroll        = self.$dropdown_content.scrollTop() || 0;
                y             = self.$activeOption.offset().top - self.$dropdown_content.offset().top + scroll;
                scroll_top    = y;
                scroll_bottom = y - height_menu + height_item;

                if (y + height_item > height_menu + scroll) {
                    self.$dropdown_content.stop().animate({scrollTop: scroll_bottom}, animate ? self.settings.scrollDuration : 0);
                } else if (y < scroll) {
                    self.$dropdown_content.stop().animate({scrollTop: scroll_top}, animate ? self.settings.scrollDuration : 0);
                }

            }
        },

        /**
         * Selects all items (CTRL + A).
         */
        selectAll: function() {
            var self = this;
            if (self.settings.mode === 'single') return;

            self.$activeItems = Array.prototype.slice.apply(self.$control.children(':not(input)').addClass('active'));
            if (self.$activeItems.length) {
                self.hideInput();
                self.close();
            }
            self.focus();
        },

        /**
         * Hides the input element out of view, while
         * retaining its focus.
         */
        hideInput: function() {
            var self = this;

            self.setTextboxValue('');
            self.$control_input.css({opacity: 0, position: 'absolute', left: self.rtl ? 10000 : -10000});
            self.isInputHidden = true;
        },

        /**
         * Restores input visibility.
         */
        showInput: function() {
            this.$control_input.css({opacity: 1, position: 'relative', left: 0});
            this.isInputHidden = false;
        },

        /**
         * Gives the control focus.
         */
        focus: function() {
            var self = this;
            if (self.isDisabled) return;

            self.ignoreFocus = true;
            self.$control_input[0].focus();
            window.setTimeout(function() {
                self.ignoreFocus = false;
                self.onFocus();
            }, 0);
        },

        /**
         * Forces the control out of focus.
         *
         * @param {Element} dest
         */
        blur: function(dest) {
            this.$control_input[0].blur();
            this.onBlur(null, dest);
        },

        /**
         * Returns a function that scores an object
         * to show how good of a match it is to the
         * provided query.
         *
         * @param {string} query
         * @param {object} options
         * @return {function}
         */
        getScoreFunction: function(query) {
            return this.sifter.getScoreFunction(query, this.getSearchOptions());
        },

        /**
         * Returns search options for sifter (the system
         * for scoring and sorting results).
         *
         * @see https://github.com/brianreavis/sifter.js
         * @return {object}
         */
        getSearchOptions: function() {
            var settings = this.settings;
            var sort = settings.sortField;
            if (typeof sort === 'string') {
                sort = [{field: sort}];
            }

            return {
                fields      : settings.searchField,
                conjunction : settings.searchConjunction,
                sort        : sort
            };
        },

        /**
         * Searches through available options and returns
         * a sorted array of matches.
         *
         * Returns an object containing:
         *
         *   - query {string}
         *   - tokens {array}
         *   - total {int}
         *   - items {array}
         *
         * @param {string} query
         * @returns {object}
         */
        search: function(query) {
            var i, value, score, result, calculateScore;
            var self     = this;
            var settings = self.settings;
            var options  = this.getSearchOptions();

            // validate user-provided result scoring function
            if (settings.score) {
                calculateScore = self.settings.score.apply(this, [query]);
                if (typeof calculateScore !== 'function') {
                    throw new Error('Selectize "score" setting must be a function that returns a function');
                }
            }

            // perform search
            if (query !== self.lastQuery) {
                self.lastQuery = query;
                result = self.sifter.search(query, $.extend(options, {score: calculateScore}));
                self.currentResults = result;
            } else {
                result = $.extend(true, {}, self.currentResults);
            }

            // filter out selected items
            if (settings.hideSelected) {
                for (i = result.items.length - 1; i >= 0; i--) {
                    if (self.items.indexOf(hash_key(result.items[i].id)) !== -1) {
                        result.items.splice(i, 1);
                    }
                }
            }

            return result;
        },

        /**
         * Refreshes the list of available options shown
         * in the autocomplete dropdown menu.
         *
         * @param {boolean} triggerDropdown
         */
        refreshOptions: function(triggerDropdown) {
            var i, j, k, n, groups, groups_order, option, option_html, optgroup, optgroups, html, html_children, has_create_option;
            var $active, $active_before, $create;

            if (typeof triggerDropdown === 'undefined') {
                triggerDropdown = true;
            }

            var self              = this;
            var query             = $.trim(self.$control_input.val());
            var results           = self.search(query);
            var $dropdown_content = self.$dropdown_content;
            var active_before     = self.$activeOption && hash_key(self.$activeOption.attr('data-value'));

            // build markup
            n = results.items.length;
            if (typeof self.settings.maxOptions === 'number') {
                n = Math.min(n, self.settings.maxOptions);
            }

            // render and group available options individually
            groups = {};
            groups_order = [];

            for (i = 0; i < n; i++) {
                option      = self.options[results.items[i].id];
                option_html = self.render('option', option);
                optgroup    = option[self.settings.optgroupField] || '';
                optgroups   = $.isArray(optgroup) ? optgroup : [optgroup];

                for (j = 0, k = optgroups && optgroups.length; j < k; j++) {
                    optgroup = optgroups[j];
                    if (!self.optgroups.hasOwnProperty(optgroup)) {
                        optgroup = '';
                    }
                    if (!groups.hasOwnProperty(optgroup)) {
                        groups[optgroup] = document.createDocumentFragment();
                        groups_order.push(optgroup);
                    }
                    groups[optgroup].appendChild(option_html);
                }
            }

            // sort optgroups
            if (this.settings.lockOptgroupOrder) {
                groups_order.sort(function(a, b) {
                    var a_order = self.optgroups[a].$order || 0;
                    var b_order = self.optgroups[b].$order || 0;
                    return a_order - b_order;
                });
            }

            // render optgroup headers & join groups
            html = document.createDocumentFragment();
            for (i = 0, n = groups_order.length; i < n; i++) {
                optgroup = groups_order[i];
                if (self.optgroups.hasOwnProperty(optgroup) && groups[optgroup].childNodes.length) {
                    // render the optgroup header and options within it,
                    // then pass it to the wrapper template
                    html_children = document.createDocumentFragment();
                    html_children.appendChild(self.render('optgroup_header', self.optgroups[optgroup]));
                    html_children.appendChild(groups[optgroup]);

                    html.appendChild(self.render('optgroup', $.extend({}, self.optgroups[optgroup], {
                        html: domToString(html_children),
                        dom:  html_children
                    })));
                } else {
                    html.appendChild(groups[optgroup]);
                }
            }

            $dropdown_content.html(html);

            // highlight matching terms inline
            if (self.settings.highlight && results.query.length && results.tokens.length) {
                $dropdown_content.removeHighlight();
                for (i = 0, n = results.tokens.length; i < n; i++) {
                    highlight($dropdown_content, results.tokens[i].regex);
                }
            }

            // add "selected" class to selected options
            if (!self.settings.hideSelected) {
                for (i = 0, n = self.items.length; i < n; i++) {
                    self.getOption(self.items[i]).addClass('selected');
                }
            }

            // add create option
            has_create_option = self.canCreate(query);
            if (has_create_option) {
                $dropdown_content.prepend(self.render('option_create', {input: query}));
                $create = $($dropdown_content[0].childNodes[0]);
            }

            // activate
            self.hasOptions = results.items.length > 0 || has_create_option;
            if (self.hasOptions) {
                if (results.items.length > 0) {
                    $active_before = active_before && self.getOption(active_before);
                    if ($active_before && $active_before.length) {
                        $active = $active_before;
                    } else if (self.settings.mode === 'single' && self.items.length) {
                        $active = self.getOption(self.items[0]);
                    }
                    if (!$active || !$active.length) {
                        if ($create && !self.settings.addPrecedence) {
                            $active = self.getAdjacentOption($create, 1);
                        } else {
                            $active = $dropdown_content.find('[data-selectable]:first');
                        }
                    }
                } else {
                    $active = $create;
                }
                self.setActiveOption($active);
                if (triggerDropdown && !self.isOpen) { self.open(); }
            } else {
                self.setActiveOption(null);
                if (triggerDropdown && self.isOpen) { self.close(); }
            }
        },

        /**
         * Adds an available option. If it already exists,
         * nothing will happen. Note: this does not refresh
         * the options list dropdown (use `refreshOptions`
         * for that).
         *
         * Usage:
         *
         *   this.addOption(data)
         *
         * @param {object|array} data
         */
        addOption: function(data) {
            var i, n, value, self = this;

            if ($.isArray(data)) {
                for (i = 0, n = data.length; i < n; i++) {
                    self.addOption(data[i]);
                }
                return;
            }

            if (value = self.registerOption(data)) {
                self.userOptions[value] = true;
                self.lastQuery = null;
                self.trigger('option_add', value, data);
            }
        },

        /**
         * Registers an option to the pool of options.
         *
         * @param {object} data
         * @return {boolean|string}
         */
        registerOption: function(data) {
            var key = hash_key(data[this.settings.valueField]);
            if (typeof key === 'undefined' || key === null || this.options.hasOwnProperty(key)) return false;
            data.$order = data.$order || ++this.order;
            this.options[key] = data;
            return key;
        },

        /**
         * Registers an option group to the pool of option groups.
         *
         * @param {object} data
         * @return {boolean|string}
         */
        registerOptionGroup: function(data) {
            var key = hash_key(data[this.settings.optgroupValueField]);
            if (!key) return false;

            data.$order = data.$order || ++this.order;
            this.optgroups[key] = data;
            return key;
        },

        /**
         * Registers a new optgroup for options
         * to be bucketed into.
         *
         * @param {string} id
         * @param {object} data
         */
        addOptionGroup: function(id, data) {
            data[this.settings.optgroupValueField] = id;
            if (id = this.registerOptionGroup(data)) {
                this.trigger('optgroup_add', id, data);
            }
        },

        /**
         * Removes an existing option group.
         *
         * @param {string} id
         */
        removeOptionGroup: function(id) {
            if (this.optgroups.hasOwnProperty(id)) {
                delete this.optgroups[id];
                this.renderCache = {};
                this.trigger('optgroup_remove', id);
            }
        },

        /**
         * Clears all existing option groups.
         */
        clearOptionGroups: function() {
            this.optgroups = {};
            this.renderCache = {};
            this.trigger('optgroup_clear');
        },

        /**
         * Updates an option available for selection. If
         * it is visible in the selected items or options
         * dropdown, it will be re-rendered automatically.
         *
         * @param {string} value
         * @param {object} data
         */
        updateOption: function(value, data) {
            var self = this;
            var $item, $item_new;
            var value_new, index_item, cache_items, cache_options, order_old;

            value     = hash_key(value);
            value_new = hash_key(data[self.settings.valueField]);

            // sanity checks
            if (value === null) return;
            if (!self.options.hasOwnProperty(value)) return;
            if (typeof value_new !== 'string') throw new Error('Value must be set in option data');

            order_old = self.options[value].$order;

            // update references
            if (value_new !== value) {
                delete self.options[value];
                index_item = self.items.indexOf(value);
                if (index_item !== -1) {
                    self.items.splice(index_item, 1, value_new);
                }
            }
            data.$order = data.$order || order_old;
            self.options[value_new] = data;

            // invalidate render cache
            cache_items = self.renderCache['item'];
            cache_options = self.renderCache['option'];

            if (cache_items) {
                delete cache_items[value];
                delete cache_items[value_new];
            }
            if (cache_options) {
                delete cache_options[value];
                delete cache_options[value_new];
            }

            // update the item if it's selected
            if (self.items.indexOf(value_new) !== -1) {
                $item = self.getItem(value);
                $item_new = $(self.render('item', data));
                if ($item.hasClass('active')) $item_new.addClass('active');
                $item.replaceWith($item_new);
            }

            // invalidate last query because we might have updated the sortField
            self.lastQuery = null;

            // update dropdown contents
            if (self.isOpen) {
                self.refreshOptions(false);
            }
        },

        /**
         * Removes a single option.
         *
         * @param {string} value
         * @param {boolean} silent
         */
        removeOption: function(value, silent) {
            var self = this;
            value = hash_key(value);

            var cache_items = self.renderCache['item'];
            var cache_options = self.renderCache['option'];
            if (cache_items) delete cache_items[value];
            if (cache_options) delete cache_options[value];

            delete self.userOptions[value];
            delete self.options[value];
            self.lastQuery = null;
            self.trigger('option_remove', value);
            self.removeItem(value, silent);
        },

        /**
         * Clears all options.
         */
        clearOptions: function() {
            var self = this;

            self.loadedSearches = {};
            self.userOptions = {};
            self.renderCache = {};
            self.options = self.sifter.items = {};
            self.lastQuery = null;
            self.trigger('option_clear');
            self.clear();
        },

        /**
         * Returns the jQuery element of the option
         * matching the given value.
         *
         * @param {string} value
         * @returns {object}
         */
        getOption: function(value) {
            return this.getElementWithValue(value, this.$dropdown_content.find('[data-selectable]'));
        },

        /**
         * Returns the jQuery element of the next or
         * previous selectable option.
         *
         * @param {object} $option
         * @param {int} direction  can be 1 for next or -1 for previous
         * @return {object}
         */
        getAdjacentOption: function($option, direction) {
            var $options = this.$dropdown.find('[data-selectable]');
            var index    = $options.index($option) + direction;

            return index >= 0 && index < $options.length ? $options.eq(index) : $();
        },

        /**
         * Finds the first element with a "data-value" attribute
         * that matches the given value.
         *
         * @param {mixed} value
         * @param {object} $els
         * @return {object}
         */
        getElementWithValue: function(value, $els) {
            value = hash_key(value);

            if (typeof value !== 'undefined' && value !== null) {
                for (var i = 0, n = $els.length; i < n; i++) {
                    if ($els[i].getAttribute('data-value') === value) {
                        return $($els[i]);
                    }
                }
            }

            return $();
        },

        /**
         * Returns the jQuery element of the item
         * matching the given value.
         *
         * @param {string} value
         * @returns {object}
         */
        getItem: function(value) {
            return this.getElementWithValue(value, this.$control.children());
        },

        /**
         * "Selects" multiple items at once. Adds them to the list
         * at the current caret position.
         *
         * @param {string} value
         * @param {boolean} silent
         */
        addItems: function(values, silent) {
            var items = $.isArray(values) ? values : [values];
            for (var i = 0, n = items.length; i < n; i++) {
                this.isPending = (i < n - 1);
                this.addItem(items[i], silent);
            }
        },

        /**
         * "Selects" an item. Adds it to the list
         * at the current caret position.
         *
         * @param {string} value
         * @param {boolean} silent
         */
        addItem: function(value, silent) {
            var events = silent ? [] : ['change'];

            debounce_events(this, events, function() {
                var $item, $option, $options;
                var self = this;
                var inputMode = self.settings.mode;
                var i, active, value_next, wasFull;
                value = hash_key(value);

                if (self.items.indexOf(value) !== -1) {
                    if (inputMode === 'single') self.close();
                    return;
                }

                if (!self.options.hasOwnProperty(value)) return;
                if (inputMode === 'single') self.clear(silent);
                if (inputMode === 'multi' && self.isFull()) return;

                $item = $(self.render('item', self.options[value]));
                wasFull = self.isFull();
                self.items.splice(self.caretPos, 0, value);
                self.insertAtCaret($item);
                if (!self.isPending || (!wasFull && self.isFull())) {
                    self.refreshState();
                }

                if (self.isSetup) {
                    $options = self.$dropdown_content.find('[data-selectable]');

                    // update menu / remove the option (if this is not one item being added as part of series)
                    if (!self.isPending) {
                        $option = self.getOption(value);
                        value_next = self.getAdjacentOption($option, 1).attr('data-value');
                        self.refreshOptions(self.isFocused && inputMode !== 'single');
                        if (value_next) {
                            self.setActiveOption(self.getOption(value_next));
                        }
                    }

                    // hide the menu if the maximum number of items have been selected or no options are left
                    if (!$options.length || self.isFull()) {
                        self.close();
                    } else {
                        self.positionDropdown();
                    }

                    self.updatePlaceholder();
                    self.trigger('item_add', value, $item);
                    self.updateOriginalInput({silent: silent});
                }
            });
        },

        /**
         * Removes the selected item matching
         * the provided value.
         *
         * @param {string} value
         */
        removeItem: function(value, silent) {
            var self = this;
            var $item, i, idx;

            $item = (value instanceof $) ? value : self.getItem(value);
            value = hash_key($item.attr('data-value'));
            i = self.items.indexOf(value);

            if (i !== -1) {
                $item.remove();
                if ($item.hasClass('active')) {
                    idx = self.$activeItems.indexOf($item[0]);
                    self.$activeItems.splice(idx, 1);
                }

                self.items.splice(i, 1);
                self.lastQuery = null;
                if (!self.settings.persist && self.userOptions.hasOwnProperty(value)) {
                    self.removeOption(value, silent);
                }

                if (i < self.caretPos) {
                    self.setCaret(self.caretPos - 1);
                }

                self.refreshState();
                self.updatePlaceholder();
                self.updateOriginalInput({silent: silent});
                self.positionDropdown();
                self.trigger('item_remove', value, $item);
            }
        },

        /**
         * Invokes the `create` method provided in the
         * selectize options that should provide the data
         * for the new item, given the user input.
         *
         * Once this completes, it will be added
         * to the item list.
         *
         * @param {string} value
         * @param {boolean} [triggerDropdown]
         * @param {function} [callback]
         * @return {boolean}
         */
        createItem: function(input, triggerDropdown) {
            var self  = this;
            var caret = self.caretPos;
            input = input || $.trim(self.$control_input.val() || '');

            var callback = arguments[arguments.length - 1];
            if (typeof callback !== 'function') callback = function() {};

            if (typeof triggerDropdown !== 'boolean') {
                triggerDropdown = true;
            }

            if (!self.canCreate(input)) {
                callback();
                return false;
            }

            self.lock();

            var setup = (typeof self.settings.create === 'function') ? this.settings.create : function(input) {
                var data = {};
                data[self.settings.labelField] = input;
                data[self.settings.valueField] = input;
                return data;
            };

            var create = once(function(data) {
                self.unlock();

                if (!data || typeof data !== 'object') return callback();
                var value = hash_key(data[self.settings.valueField]);
                if (typeof value !== 'string') return callback();

                self.setTextboxValue('');
                self.addOption(data);
                self.setCaret(caret);
                self.addItem(value);
                self.refreshOptions(triggerDropdown && self.settings.mode !== 'single');
                callback(data);
            });

            var output = setup.apply(this, [input, create]);
            if (typeof output !== 'undefined') {
                create(output);
            }

            return true;
        },

        /**
         * Re-renders the selected item lists.
         */
        refreshItems: function() {
            this.lastQuery = null;

            if (this.isSetup) {
                this.addItem(this.items);
            }

            this.refreshState();
            this.updateOriginalInput();
        },

        /**
         * Updates all state-dependent attributes
         * and CSS classes.
         */
        refreshState: function() {
            this.refreshValidityState();
            this.refreshClasses();
        },

        /**
         * Update the `required` attribute of both input and control input.
         *
         * The `required` property needs to be activated on the control input
         * for the error to be displayed at the right place. `required` also
         * needs to be temporarily deactivated on the input since the input is
         * hidden and can't show errors.
         */
        refreshValidityState: function() {
            if (!this.isRequired) return false;

            var invalid = !this.items.length;

            this.isInvalid = invalid;
            this.$control_input.prop('required', invalid);
            this.$input.prop('required', !invalid);
        },

        /**
         * Updates all state-dependent CSS classes.
         */
        refreshClasses: function() {
            var self     = this;
            var isFull   = self.isFull();
            var isLocked = self.isLocked;

            self.$wrapper
                .toggleClass('rtl', self.rtl);

            self.$control
                .toggleClass('focus', self.isFocused)
                .toggleClass('disabled', self.isDisabled)
                .toggleClass('required', self.isRequired)
                .toggleClass('invalid', self.isInvalid)
                .toggleClass('locked', isLocked)
                .toggleClass('full', isFull).toggleClass('not-full', !isFull)
                .toggleClass('input-active', self.isFocused && !self.isInputHidden)
                .toggleClass('dropdown-active', self.isOpen)
                .toggleClass('has-options', !$.isEmptyObject(self.options))
                .toggleClass('has-items', self.items.length > 0);

            self.$control_input.data('grow', !isFull && !isLocked);
        },

        /**
         * Determines whether or not more items can be added
         * to the control without exceeding the user-defined maximum.
         *
         * @returns {boolean}
         */
        isFull: function() {
            return this.settings.maxItems !== null && this.items.length >= this.settings.maxItems;
        },

        /**
         * Refreshes the original <select> or <input>
         * element to reflect the current state.
         */
        updateOriginalInput: function(opts) {
            var i, n, options, label, self = this;
            opts = opts || {};

            if (self.tagType === TAG_SELECT) {
                options = [];
                for (i = 0, n = self.items.length; i < n; i++) {
                    label = self.options[self.items[i]][self.settings.labelField] || '';
                    options.push('<option value="' + escape_html(self.items[i]) + '" selected="selected">' + escape_html(label) + '</option>');
                }
                if (!options.length && !this.$input.attr('multiple')) {
                    options.push('<option value="" selected="selected"></option>');
                }
                self.$input.html(options.join(''));
            } else {
                self.$input.val(self.getValue());
                self.$input.attr('value',self.$input.val());
            }

            if (self.isSetup) {
                if (!opts.silent) {
                    self.trigger('change', self.$input.val());
                }
            }
        },

        /**
         * Shows/hide the input placeholder depending
         * on if there items in the list already.
         */
        updatePlaceholder: function() {
            if (!this.settings.placeholder) return;
            var $input = this.$control_input;

            if (this.items.length) {
                $input.removeAttr('placeholder');
            } else {
                $input.attr('placeholder', this.settings.placeholder);
            }
            $input.triggerHandler('update', {force: true});
        },

        /**
         * Shows the autocomplete dropdown containing
         * the available options.
         */
        open: function() {
            var self = this;

            if (self.isLocked || self.isOpen || (self.settings.mode === 'multi' && self.isFull())) return;
            self.focus();
            self.isOpen = true;
            self.refreshState();
            self.$dropdown.css({visibility: 'hidden', display: 'block'});
            self.positionDropdown();
            self.$dropdown.css({visibility: 'visible'});
            self.trigger('dropdown_open', self.$dropdown);
        },

        /**
         * Closes the autocomplete dropdown menu.
         */
        close: function() {
            var self = this;
            var trigger = self.isOpen;

            if (self.settings.mode === 'single' && self.items.length) {
                self.hideInput();
                self.$control_input.blur(); // close keyboard on iOS
            }

            self.isOpen = false;
            self.$dropdown.hide();
            self.setActiveOption(null);
            self.refreshState();

            if (trigger) self.trigger('dropdown_close', self.$dropdown);
        },

        /**
         * Calculates and applies the appropriate
         * position of the dropdown.
         */
        positionDropdown: function() {
            var $control = this.$control;
            var offset = this.settings.dropdownParent === 'body' ? $control.offset() : $control.position();
            offset.top += $control.outerHeight(true);

            this.$dropdown.css({
                width : $control.outerWidth(),
                top   : offset.top,
                left  : offset.left
            });
        },

        /**
         * Resets / clears all selected items
         * from the control.
         *
         * @param {boolean} silent
         */
        clear: function(silent) {
            var self = this;

            if (!self.items.length) return;
            self.$control.children(':not(input)').remove();
            self.items = [];
            self.lastQuery = null;
            self.setCaret(0);
            self.setActiveItem(null);
            self.updatePlaceholder();
            self.updateOriginalInput({silent: silent});
            self.refreshState();
            self.showInput();
            self.trigger('clear');
        },

        /**
         * A helper method for inserting an element
         * at the current caret position.
         *
         * @param {object} $el
         */
        insertAtCaret: function($el) {
            var caret = Math.min(this.caretPos, this.items.length);
            if (caret === 0) {
                this.$control.prepend($el);
            } else {
                $(this.$control[0].childNodes[caret]).before($el);
            }
            this.setCaret(caret + 1);
        },

        /**
         * Removes the current selected item(s).
         *
         * @param {object} e (optional)
         * @returns {boolean}
         */
        deleteSelection: function(e) {
            var i, n, direction, selection, values, caret, option_select, $option_select, $tail;
            var self = this;

            direction = (e && e.keyCode === KEY_BACKSPACE) ? -1 : 1;
            selection = getSelection(self.$control_input[0]);

            if (self.$activeOption && !self.settings.hideSelected) {
                option_select = self.getAdjacentOption(self.$activeOption, -1).attr('data-value');
            }

            // determine items that will be removed
            values = [];

            if (self.$activeItems.length) {
                $tail = self.$control.children('.active:' + (direction > 0 ? 'last' : 'first'));
                caret = self.$control.children(':not(input)').index($tail);
                if (direction > 0) { caret++; }

                for (i = 0, n = self.$activeItems.length; i < n; i++) {
                    values.push($(self.$activeItems[i]).attr('data-value'));
                }
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            } else if ((self.isFocused || self.settings.mode === 'single') && self.items.length) {
                if (direction < 0 && selection.start === 0 && selection.length === 0) {
                    values.push(self.items[self.caretPos - 1]);
                } else if (direction > 0 && selection.start === self.$control_input.val().length) {
                    values.push(self.items[self.caretPos]);
                }
            }

            // allow the callback to abort
            if (!values.length || (typeof self.settings.onDelete === 'function' && self.settings.onDelete.apply(self, [values]) === false)) {
                return false;
            }

            // perform removal
            if (typeof caret !== 'undefined') {
                self.setCaret(caret);
            }
            while (values.length) {
                self.removeItem(values.pop());
            }

            self.showInput();
            self.positionDropdown();
            self.refreshOptions(true);

            // select previous option
            if (option_select) {
                $option_select = self.getOption(option_select);
                if ($option_select.length) {
                    self.setActiveOption($option_select);
                }
            }

            return true;
        },

        /**
         * Selects the previous / next item (depending
         * on the `direction` argument).
         *
         * > 0 - right
         * < 0 - left
         *
         * @param {int} direction
         * @param {object} e (optional)
         */
        advanceSelection: function(direction, e) {
            var tail, selection, idx, valueLength, cursorAtEdge, $tail;
            var self = this;

            if (direction === 0) return;
            if (self.rtl) direction *= -1;

            tail = direction > 0 ? 'last' : 'first';
            selection = getSelection(self.$control_input[0]);

            if (self.isFocused && !self.isInputHidden) {
                valueLength = self.$control_input.val().length;
                cursorAtEdge = direction < 0
                    ? selection.start === 0 && selection.length === 0
                    : selection.start === valueLength;

                if (cursorAtEdge && !valueLength) {
                    self.advanceCaret(direction, e);
                }
            } else {
                $tail = self.$control.children('.active:' + tail);
                if ($tail.length) {
                    idx = self.$control.children(':not(input)').index($tail);
                    self.setActiveItem(null);
                    self.setCaret(direction > 0 ? idx + 1 : idx);
                }
            }
        },

        /**
         * Moves the caret left / right.
         *
         * @param {int} direction
         * @param {object} e (optional)
         */
        advanceCaret: function(direction, e) {
            var self = this, fn, $adj;

            if (direction === 0) return;

            fn = direction > 0 ? 'next' : 'prev';
            if (self.isShiftDown) {
                $adj = self.$control_input[fn]();
                if ($adj.length) {
                    self.hideInput();
                    self.setActiveItem($adj);
                    e && e.preventDefault();
                }
            } else {
                self.setCaret(self.caretPos + direction);
            }
        },

        /**
         * Moves the caret to the specified index.
         *
         * @param {int} i
         */
        setCaret: function(i) {
            var self = this;

            if (self.settings.mode === 'single') {
                i = self.items.length;
            } else {
                i = Math.max(0, Math.min(self.items.length, i));
            }

            if(!self.isPending) {
                // the input must be moved by leaving it in place and moving the
                // siblings, due to the fact that focus cannot be restored once lost
                // on mobile webkit devices
                var j, n, fn, $children, $child;
                $children = self.$control.children(':not(input)');
                for (j = 0, n = $children.length; j < n; j++) {
                    $child = $($children[j]).detach();
                    if (j <  i) {
                        self.$control_input.before($child);
                    } else {
                        self.$control.append($child);
                    }
                }
            }

            self.caretPos = i;
        },

        /**
         * Disables user input on the control. Used while
         * items are being asynchronously created.
         */
        lock: function() {
            this.close();
            this.isLocked = true;
            this.refreshState();
        },

        /**
         * Re-enables user input on the control.
         */
        unlock: function() {
            this.isLocked = false;
            this.refreshState();
        },

        /**
         * Disables user input on the control completely.
         * While disabled, it cannot receive focus.
         */
        disable: function() {
            var self = this;
            self.$input.prop('disabled', true);
            self.$control_input.prop('disabled', true).prop('tabindex', -1);
            self.isDisabled = true;
            self.lock();
        },

        /**
         * Enables the control so that it can respond
         * to focus and user input.
         */
        enable: function() {
            var self = this;
            self.$input.prop('disabled', false);
            self.$control_input.prop('disabled', false).prop('tabindex', self.tabIndex);
            self.isDisabled = false;
            self.unlock();
        },

        /**
         * Completely destroys the control and
         * unbinds all event listeners so that it can
         * be garbage collected.
         */
        destroy: function() {
            var self = this;
            var eventNS = self.eventNS;
            var revertSettings = self.revertSettings;

            self.trigger('destroy');
            self.off();
            self.$wrapper.remove();
            self.$dropdown.remove();

            self.$input
                .html('')
                .append(revertSettings.$children)
                .removeAttr('tabindex')
                .removeClass('selectized')
                .attr({tabindex: revertSettings.tabindex})
                .show();

            self.$control_input.removeData('grow');
            self.$input.removeData('selectize');

            $(window).off(eventNS);
            $(document).off(eventNS);
            $(document.body).off(eventNS);

            delete self.$input[0].selectize;
        },

        /**
         * A helper method for rendering "item" and
         * "option" templates, given the data.
         *
         * @param {string} templateName
         * @param {object} data
         * @returns {string}
         */
        render: function(templateName, data) {
            var value, id, label;
            var html = '';
            var cache = false;
            var self = this;
            var regex_tag = /^[\t \r\n]*<([a-z][a-z0-9\-_]*(?:\:[a-z][a-z0-9\-_]*)?)/i;

            if (templateName === 'option' || templateName === 'item') {
                value = hash_key(data[self.settings.valueField]);
                cache = !!value;
            }

            // pull markup from cache if it exists
            if (cache) {
                if (!isset(self.renderCache[templateName])) {
                    self.renderCache[templateName] = {};
                }
                if (self.renderCache[templateName].hasOwnProperty(value)) {
                    return self.renderCache[templateName][value];
                }
            }

            // render markup
            html = $(self.settings.render[templateName].apply(this, [data, escape_html]));

            // add mandatory attributes
            if (templateName === 'option' || templateName === 'option_create') {
                html.attr('data-selectable', '');
            }
            else if (templateName === 'optgroup') {
                id = data[self.settings.optgroupValueField] || '';
                html.attr('data-group', id);
            }
            if (templateName === 'option' || templateName === 'item') {
                html.attr('data-value', value || '');
            }

            // update cache
            if (cache) {
                self.renderCache[templateName][value] = html[0];
            }

            return html[0];
        },

        /**
         * Clears the render cache for a template. If
         * no template is given, clears all render
         * caches.
         *
         * @param {string} templateName
         */
        clearCache: function(templateName) {
            var self = this;
            if (typeof templateName === 'undefined') {
                self.renderCache = {};
            } else {
                delete self.renderCache[templateName];
            }
        },

        /**
         * Determines whether or not to display the
         * create item prompt, given a user input.
         *
         * @param {string} input
         * @return {boolean}
         */
        canCreate: function(input) {
            var self = this;
            if (!self.settings.create) return false;
            var filter = self.settings.createFilter;
            return input.length
                && (typeof filter !== 'function' || filter.apply(self, [input]))
                && (typeof filter !== 'string' || new RegExp(filter).test(input))
                && (!(filter instanceof RegExp) || filter.test(input));
        }

    });


    Selectize.count = 0;
    Selectize.defaults = {
        options: [],
        optgroups: [],

        plugins: [],
        delimiter: ',',
        splitOn: null, // regexp or string for splitting up values from a paste command
        persist: true,
        diacritics: true,
        create: false,
        createOnBlur: false,
        createFilter: null,
        highlight: true,
        openOnFocus: true,
        maxOptions: 1000,
        maxItems: null,
        hideSelected: null,
        addPrecedence: false,
        selectOnTab: false,
        preload: false,
        allowEmptyOption: false,
        closeAfterSelect: false,

        scrollDuration: 60,
        loadThrottle: 300,
        loadingClass: 'loading',

        dataAttr: 'data-data',
        optgroupField: 'optgroup',
        valueField: 'value',
        labelField: 'text',
        optgroupLabelField: 'label',
        optgroupValueField: 'value',
        lockOptgroupOrder: false,

        sortField: '$order',
        searchField: ['text'],
        searchConjunction: 'and',

        mode: null,
        wrapperClass: 'selectize-control',
        inputClass: 'selectize-input',
        dropdownClass: 'selectize-dropdown',
        dropdownContentClass: 'selectize-dropdown-content',

        dropdownParent: null,

        copyClassesToDropdown: true,

        /*
		load                 : null, // function(query, callback) { ... }
		score                : null, // function(search) { ... }
		onInitialize         : null, // function() { ... }
		onChange             : null, // function(value) { ... }
		onItemAdd            : null, // function(value, $item) { ... }
		onItemRemove         : null, // function(value) { ... }
		onClear              : null, // function() { ... }
		onOptionAdd          : null, // function(value, data) { ... }
		onOptionRemove       : null, // function(value) { ... }
		onOptionClear        : null, // function() { ... }
		onOptionGroupAdd     : null, // function(id, data) { ... }
		onOptionGroupRemove  : null, // function(id) { ... }
		onOptionGroupClear   : null, // function() { ... }
		onDropdownOpen       : null, // function($dropdown) { ... }
		onDropdownClose      : null, // function($dropdown) { ... }
		onType               : null, // function(str) { ... }
		onDelete             : null, // function(values) { ... }
		*/

        render: {
            /*
			item: null,
			optgroup: null,
			optgroup_header: null,
			option: null,
			option_create: null
			*/
        }
    };


    $.fn.selectize = function(settings_user) {
        var defaults             = $.fn.selectize.defaults;
        var settings             = $.extend({}, defaults, settings_user);
        var attr_data            = settings.dataAttr;
        var field_label          = settings.labelField;
        var field_value          = settings.valueField;
        var field_optgroup       = settings.optgroupField;
        var field_optgroup_label = settings.optgroupLabelField;
        var field_optgroup_value = settings.optgroupValueField;

        /**
         * Initializes selectize from a <input type="text"> element.
         *
         * @param {object} $input
         * @param {object} settings_element
         */
        var init_textbox = function($input, settings_element) {
            var i, n, values, option;

            var data_raw = $input.attr(attr_data);

            if (!data_raw) {
                var value = $.trim($input.val() || '');
                if (!settings.allowEmptyOption && !value.length) return;
                values = value.split(settings.delimiter);
                for (i = 0, n = values.length; i < n; i++) {
                    option = {};
                    option[field_label] = values[i];
                    option[field_value] = values[i];
                    settings_element.options.push(option);
                }
                settings_element.items = values;
            } else {
                settings_element.options = JSON.parse(data_raw);
                for (i = 0, n = settings_element.options.length; i < n; i++) {
                    settings_element.items.push(settings_element.options[i][field_value]);
                }
            }
        };

        /**
         * Initializes selectize from a <select> element.
         *
         * @param {object} $input
         * @param {object} settings_element
         */
        var init_select = function($input, settings_element) {
            var i, n, tagName, $children, order = 0;
            var options = settings_element.options;
            var optionsMap = {};

            var readData = function($el) {
                var data = attr_data && $el.attr(attr_data);
                if (typeof data === 'string' && data.length) {
                    return JSON.parse(data);
                }
                return null;
            };

            var addOption = function($option, group) {
                $option = $($option);

                var value = hash_key($option.val());
                if (!value && !settings.allowEmptyOption) return;

                // if the option already exists, it's probably been
                // duplicated in another optgroup. in this case, push
                // the current group to the "optgroup" property on the
                // existing option so that it's rendered in both places.
                if (optionsMap.hasOwnProperty(value)) {
                    if (group) {
                        var arr = optionsMap[value][field_optgroup];
                        if (!arr) {
                            optionsMap[value][field_optgroup] = group;
                        } else if (!$.isArray(arr)) {
                            optionsMap[value][field_optgroup] = [arr, group];
                        } else {
                            arr.push(group);
                        }
                    }
                    return;
                }

                var option             = readData($option) || {};
                option[field_label]    = option[field_label] || $option.text();
                option[field_value]    = option[field_value] || value;
                option[field_optgroup] = option[field_optgroup] || group;

                optionsMap[value] = option;
                options.push(option);

                if ($option.is(':selected')) {
                    settings_element.items.push(value);
                }
            };

            var addGroup = function($optgroup) {
                var i, n, id, optgroup, $options;

                $optgroup = $($optgroup);
                id = $optgroup.attr('label');

                if (id) {
                    optgroup = readData($optgroup) || {};
                    optgroup[field_optgroup_label] = id;
                    optgroup[field_optgroup_value] = id;
                    settings_element.optgroups.push(optgroup);
                }

                $options = $('option', $optgroup);
                for (i = 0, n = $options.length; i < n; i++) {
                    addOption($options[i], id);
                }
            };

            settings_element.maxItems = $input.attr('multiple') ? null : 1;

            $children = $input.children();
            for (i = 0, n = $children.length; i < n; i++) {
                tagName = $children[i].tagName.toLowerCase();
                if (tagName === 'optgroup') {
                    addGroup($children[i]);
                } else if (tagName === 'option') {
                    addOption($children[i]);
                }
            }
        };

        return this.each(function() {
            if (this.selectize) return;

            var instance;
            var $input = $(this);
            var tag_name = this.tagName.toLowerCase();
            var placeholder = $input.attr('placeholder') || $input.attr('data-placeholder');
            if (!placeholder && !settings.allowEmptyOption) {
                placeholder = $input.children('option[value=""]').text();
            }

            var settings_element = {
                'placeholder' : placeholder,
                'options'     : [],
                'optgroups'   : [],
                'items'       : []
            };

            if (tag_name === 'select') {
                init_select($input, settings_element);
            } else {
                init_textbox($input, settings_element);
            }

            instance = new Selectize($input, $.extend(true, {}, defaults, settings_element, settings_user));
        });
    };

    $.fn.selectize.defaults = Selectize.defaults;
    $.fn.selectize.support = {
        validity: SUPPORTS_VALIDITY_API
    };


    Selectize.define('drag_drop', function(options) {
        if (!$.fn.sortable) throw new Error('The "drag_drop" plugin requires jQuery UI "sortable".');
        if (this.settings.mode !== 'multi') return;
        var self = this;

        self.lock = (function() {
            var original = self.lock;
            return function() {
                var sortable = self.$control.data('sortable');
                if (sortable) sortable.disable();
                return original.apply(self, arguments);
            };
        })();

        self.unlock = (function() {
            var original = self.unlock;
            return function() {
                var sortable = self.$control.data('sortable');
                if (sortable) sortable.enable();
                return original.apply(self, arguments);
            };
        })();

        self.setup = (function() {
            var original = self.setup;
            return function() {
                original.apply(this, arguments);

                var $control = self.$control.sortable({
                    items: '[data-value]',
                    forcePlaceholderSize: true,
                    disabled: self.isLocked,
                    start: function(e, ui) {
                        ui.placeholder.css('width', ui.helper.css('width'));
                        $control.css({overflow: 'visible'});
                    },
                    stop: function() {
                        $control.css({overflow: 'hidden'});
                        var active = self.$activeItems ? self.$activeItems.slice() : null;
                        var values = [];
                        $control.children('[data-value]').each(function() {
                            values.push($(this).attr('data-value'));
                        });
                        self.setValue(values);
                        self.setActiveItem(active);
                    }
                });
            };
        })();

    });

    Selectize.define('dropdown_header', function(options) {
        var self = this;

        options = $.extend({
            title         : 'Untitled',
            headerClass   : 'selectize-dropdown-header',
            titleRowClass : 'selectize-dropdown-header-title',
            labelClass    : 'selectize-dropdown-header-label',
            closeClass    : 'selectize-dropdown-header-close',

            html: function(data) {
                return (
                    '<div class="' + data.headerClass + '">' +
                    '<div class="' + data.titleRowClass + '">' +
                    '<span class="' + data.labelClass + '">' + data.title + '</span>' +
                    '<a href="javascript:void(0)" class="' + data.closeClass + '">&times;</a>' +
                    '</div>' +
                    '</div>'
                );
            }
        }, options);

        self.setup = (function() {
            var original = self.setup;
            return function() {
                original.apply(self, arguments);
                self.$dropdown_header = $(options.html(options));
                self.$dropdown.prepend(self.$dropdown_header);
            };
        })();

    });

    Selectize.define('optgroup_columns', function(options) {
        var self = this;

        options = $.extend({
            equalizeWidth  : true,
            equalizeHeight : true
        }, options);

        this.getAdjacentOption = function($option, direction) {
            var $options = $option.closest('[data-group]').find('[data-selectable]');
            var index    = $options.index($option) + direction;

            return index >= 0 && index < $options.length ? $options.eq(index) : $();
        };

        this.onKeyDown = (function() {
            var original = self.onKeyDown;
            return function(e) {
                var index, $option, $options, $optgroup;

                if (this.isOpen && (e.keyCode === KEY_LEFT || e.keyCode === KEY_RIGHT)) {
                    self.ignoreHover = true;
                    $optgroup = this.$activeOption.closest('[data-group]');
                    index = $optgroup.find('[data-selectable]').index(this.$activeOption);

                    if(e.keyCode === KEY_LEFT) {
                        $optgroup = $optgroup.prev('[data-group]');
                    } else {
                        $optgroup = $optgroup.next('[data-group]');
                    }

                    $options = $optgroup.find('[data-selectable]');
                    $option  = $options.eq(Math.min($options.length - 1, index));
                    if ($option.length) {
                        this.setActiveOption($option);
                    }
                    return;
                }

                return original.apply(this, arguments);
            };
        })();

        var getScrollbarWidth = function() {
            var div;
            var width = getScrollbarWidth.width;
            var doc = document;

            if (typeof width === 'undefined') {
                div = doc.createElement('div');
                div.innerHTML = '<div style="width:50px;height:50px;position:absolute;left:-50px;top:-50px;overflow:auto;"><div style="width:1px;height:100px;"></div></div>';
                div = div.firstChild;
                doc.body.appendChild(div);
                width = getScrollbarWidth.width = div.offsetWidth - div.clientWidth;
                doc.body.removeChild(div);
            }
            return width;
        };

        var equalizeSizes = function() {
            var i, n, height_max, width, width_last, width_parent, $optgroups;

            $optgroups = $('[data-group]', self.$dropdown_content);
            n = $optgroups.length;
            if (!n || !self.$dropdown_content.width()) return;

            if (options.equalizeHeight) {
                height_max = 0;
                for (i = 0; i < n; i++) {
                    height_max = Math.max(height_max, $optgroups.eq(i).height());
                }
                $optgroups.css({height: height_max});
            }

            if (options.equalizeWidth) {
                width_parent = self.$dropdown_content.innerWidth() - getScrollbarWidth();
                width = Math.round(width_parent / n);
                $optgroups.css({width: width});
                if (n > 1) {
                    width_last = width_parent - width * (n - 1);
                    $optgroups.eq(n - 1).css({width: width_last});
                }
            }
        };

        if (options.equalizeHeight || options.equalizeWidth) {
            hook.after(this, 'positionDropdown', equalizeSizes);
            hook.after(this, 'refreshOptions', equalizeSizes);
        }


    });

    Selectize.define('remove_button', function(options) {
        options = $.extend({
            label     : '&times;',
            title     : 'Remove',
            className : 'remove',
            append    : true
        }, options);

        var singleClose = function(thisRef, options) {

            options.className = 'remove-single';

            var self = thisRef;
            var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';

            /**
             * Appends an element as a child (with raw HTML).
             *
             * @param {string} html_container
             * @param {string} html_element
             * @return {string}
             */
            var append = function(html_container, html_element) {
                return html_container + html_element;
            };

            thisRef.setup = (function() {
                var original = self.setup;
                return function() {
                    // override the item rendering method to add the button to each
                    if (options.append) {
                        var id = $(self.$input.context).attr('id');
                        var selectizer = $('#'+id);

                        var render_item = self.settings.render.item;
                        self.settings.render.item = function(data) {
                            return append(render_item.apply(thisRef, arguments), html);
                        };
                    }

                    original.apply(thisRef, arguments);

                    // add event listener
                    thisRef.$control.on('click', '.' + options.className, function(e) {
                        e.preventDefault();
                        if (self.isLocked) return;

                        self.clear();
                    });

                };
            })();
        };

        var multiClose = function(thisRef, options) {

            var self = thisRef;
            var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';

            /**
             * Appends an element as a child (with raw HTML).
             *
             * @param {string} html_container
             * @param {string} html_element
             * @return {string}
             */
            var append = function(html_container, html_element) {
                var pos = html_container.search(/(<\/[^>]+>\s*)$/);
                return html_container.substring(0, pos) + html_element + html_container.substring(pos);
            };

            thisRef.setup = (function() {
                var original = self.setup;
                return function() {
                    // override the item rendering method to add the button to each
                    if (options.append) {
                        var render_item = self.settings.render.item;
                        self.settings.render.item = function(data) {
                            return append(render_item.apply(thisRef, arguments), html);
                        };
                    }

                    original.apply(thisRef, arguments);

                    // add event listener
                    thisRef.$control.on('click', '.' + options.className, function(e) {
                        e.preventDefault();
                        if (self.isLocked) return;

                        var $item = $(e.currentTarget).parent();
                        self.setActiveItem($item);
                        if (self.deleteSelection()) {
                            self.setCaret(self.items.length);
                        }
                    });

                };
            })();
        };

        if (this.settings.mode === 'single') {
            singleClose(this, options);
            return;
        } else {
            multiClose(this, options);
        }
    });


    Selectize.define('restore_on_backspace', function(options) {
        var self = this;

        options.text = options.text || function(option) {
            return option[this.settings.labelField];
        };

        this.onKeyDown = (function() {
            var original = self.onKeyDown;
            return function(e) {
                var index, option;
                if (e.keyCode === KEY_BACKSPACE && this.$control_input.val() === '' && !this.$activeItems.length) {
                    index = this.caretPos - 1;
                    if (index >= 0 && index < this.items.length) {
                        option = this.options[this.items[index]];
                        if (this.deleteSelection(e)) {
                            this.setTextboxValue(options.text.apply(this, [option]));
                            this.refreshOptions(true);
                        }
                        e.preventDefault();
                        return;
                    }
                }
                return original.apply(this, arguments);
            };
        })();
    });


    return Selectize;
}));

;(function(){

    /**
     * Require the module at `name`.
     *
     * @param {String} name
     * @return {Object} exports
     * @api public
     */

    function require(name) {
        var module = require.modules[name];
        if (!module) throw new Error('failed to require "' + name + '"');

        if (!('exports' in module) && typeof module.definition === 'function') {
            module.client = module.component = true;
            module.definition.call(this, module.exports = {}, module);
            delete module.definition;
        }

        return module.exports;
    }

    /**
     * Meta info, accessible in the global scope unless you use AMD option.
     */

    require.loader = 'component';

    /**
     * Internal helper object, contains a sorting function for semantiv versioning
     */
    require.helper = {};
    require.helper.semVerSort = function(a, b) {
        var aArray = a.version.split('.');
        var bArray = b.version.split('.');
        for (var i=0; i<aArray.length; ++i) {
            var aInt = parseInt(aArray[i], 10);
            var bInt = parseInt(bArray[i], 10);
            if (aInt === bInt) {
                var aLex = aArray[i].substr((""+aInt).length);
                var bLex = bArray[i].substr((""+bInt).length);
                if (aLex === '' && bLex !== '') return 1;
                if (aLex !== '' && bLex === '') return -1;
                if (aLex !== '' && bLex !== '') return aLex > bLex ? 1 : -1;
                continue;
            } else if (aInt > bInt) {
                return 1;
            } else {
                return -1;
            }
        }
        return 0;
    }

    /**
     * Find and require a module which name starts with the provided name.
     * If multiple modules exists, the highest semver is used.
     * This function can only be used for remote dependencies.

     * @param {String} name - module name: `user~repo`
     * @param {Boolean} returnPath - returns the canonical require path if true,
     *                               otherwise it returns the epxorted module
     */
    require.latest = function (name, returnPath) {
        function showError(name) {
            throw new Error('failed to find latest module of "' + name + '"');
        }
        // only remotes with semvers, ignore local files conataining a '/'
        var versionRegexp = /(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;
        var remoteRegexp = /(.*)~(.*)/;
        if (!remoteRegexp.test(name)) showError(name);
        var moduleNames = Object.keys(require.modules);
        var semVerCandidates = [];
        var otherCandidates = []; // for instance: name of the git branch
        for (var i=0; i<moduleNames.length; i++) {
            var moduleName = moduleNames[i];
            if (new RegExp(name + '@').test(moduleName)) {
                var version = moduleName.substr(name.length+1);
                var semVerMatch = versionRegexp.exec(moduleName);
                if (semVerMatch != null) {
                    semVerCandidates.push({version: version, name: moduleName});
                } else {
                    otherCandidates.push({version: version, name: moduleName});
                }
            }
        }
        if (semVerCandidates.concat(otherCandidates).length === 0) {
            showError(name);
        }
        if (semVerCandidates.length > 0) {
            var module = semVerCandidates.sort(require.helper.semVerSort).pop().name;
            if (returnPath === true) {
                return module;
            }
            return require(module);
        }
        // if the build contains more than one branch of the same module
        // you should not use this funciton
        var module = otherCandidates.sort(function(a, b) {return a.name > b.name})[0].name;
        if (returnPath === true) {
            return module;
        }
        return require(module);
    }

    /**
     * Registered modules.
     */

    require.modules = {};

    /**
     * Register module at `name` with callback `definition`.
     *
     * @param {String} name
     * @param {Function} definition
     * @api private
     */

    require.register = function (name, definition) {
        require.modules[name] = {
            definition: definition
        };
    };

    /**
     * Define a module's exports immediately with `exports`.
     *
     * @param {String} name
     * @param {Generic} exports
     * @api private
     */

    require.define = function (name, exports) {
        require.modules[name] = {
            exports: exports
        };
    };
    require.register("abpetkov~transitionize@0.0.3", function (exports, module) {

        /**
         * Transitionize 0.0.2
         * https://github.com/abpetkov/transitionize
         *
         * Authored by Alexander Petkov
         * https://github.com/abpetkov
         *
         * Copyright 2013, Alexander Petkov
         * License: The MIT License (MIT)
         * http://opensource.org/licenses/MIT
         *
         */

        /**
         * Expose `Transitionize`.
         */

        module.exports = Transitionize;

        /**
         * Initialize new Transitionize.
         *
         * @param {Object} element
         * @param {Object} props
         * @api public
         */

        function Transitionize(element, props) {
            if (!(this instanceof Transitionize)) return new Transitionize(element, props);

            this.element = element;
            this.props = props || {};
            this.init();
        }

        /**
         * Detect if Safari.
         *
         * @returns {Boolean}
         * @api private
         */

        Transitionize.prototype.isSafari = function() {
            return (/Safari/).test(navigator.userAgent) && (/Apple Computer/).test(navigator.vendor);
        };

        /**
         * Loop though the object and push the keys and values in an array.
         * Apply the CSS3 transition to the element and prefix with -webkit- for Safari.
         *
         * @api private
         */

        Transitionize.prototype.init = function() {
            var transitions = [];

            for (var key in this.props) {
                transitions.push(key + ' ' + this.props[key]);
            }

            this.element.style.transition = transitions.join(', ');
            if (this.isSafari()) this.element.style.webkitTransition = transitions.join(', ');
        };
    });

    require.register("ftlabs~fastclick@v0.6.11", function (exports, module) {
        /**
         * @preserve FastClick: polyfill to remove click delays on browsers with touch UIs.
         *
         * @version 0.6.11
         * @codingstandard ftlabs-jsv2
         * @copyright The Financial Times Limited [All Rights Reserved]
         * @license MIT License (see LICENSE.txt)
         */

        /*jslint browser:true, node:true*/
        /*global define, Event, Node*/


        /**
         * Instantiate fast-clicking listeners on the specificed layer.
         *
         * @constructor
         * @param {Element} layer The layer to listen on
         */
        function FastClick(layer) {
            'use strict';
            var oldOnClick, self = this;


            /**
             * Whether a click is currently being tracked.
             *
             * @type boolean
             */
            this.trackingClick = false;


            /**
             * Timestamp for when when click tracking started.
             *
             * @type number
             */
            this.trackingClickStart = 0;


            /**
             * The element being tracked for a click.
             *
             * @type EventTarget
             */
            this.targetElement = null;


            /**
             * X-coordinate of touch start event.
             *
             * @type number
             */
            this.touchStartX = 0;


            /**
             * Y-coordinate of touch start event.
             *
             * @type number
             */
            this.touchStartY = 0;


            /**
             * ID of the last touch, retrieved from Touch.identifier.
             *
             * @type number
             */
            this.lastTouchIdentifier = 0;


            /**
             * Touchmove boundary, beyond which a click will be cancelled.
             *
             * @type number
             */
            this.touchBoundary = 10;


            /**
             * The FastClick layer.
             *
             * @type Element
             */
            this.layer = layer;

            if (!layer || !layer.nodeType) {
                throw new TypeError('Layer must be a document node');
            }

            /** @type function() */
            this.onClick = function() { return FastClick.prototype.onClick.apply(self, arguments); };

            /** @type function() */
            this.onMouse = function() { return FastClick.prototype.onMouse.apply(self, arguments); };

            /** @type function() */
            this.onTouchStart = function() { return FastClick.prototype.onTouchStart.apply(self, arguments); };

            /** @type function() */
            this.onTouchMove = function() { return FastClick.prototype.onTouchMove.apply(self, arguments); };

            /** @type function() */
            this.onTouchEnd = function() { return FastClick.prototype.onTouchEnd.apply(self, arguments); };

            /** @type function() */
            this.onTouchCancel = function() { return FastClick.prototype.onTouchCancel.apply(self, arguments); };

            if (FastClick.notNeeded(layer)) {
                return;
            }

            // Set up event handlers as required
            if (this.deviceIsAndroid) {
                layer.addEventListener('mouseover', this.onMouse, true);
                layer.addEventListener('mousedown', this.onMouse, true);
                layer.addEventListener('mouseup', this.onMouse, true);
            }

            layer.addEventListener('click', this.onClick, true);
            layer.addEventListener('touchstart', this.onTouchStart, false);
            layer.addEventListener('touchmove', this.onTouchMove, false);
            layer.addEventListener('touchend', this.onTouchEnd, false);
            layer.addEventListener('touchcancel', this.onTouchCancel, false);

            // Hack is required for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
            // which is how FastClick normally stops click events bubbling to callbacks registered on the FastClick
            // layer when they are cancelled.
            if (!Event.prototype.stopImmediatePropagation) {
                layer.removeEventListener = function(type, callback, capture) {
                    var rmv = Node.prototype.removeEventListener;
                    if (type === 'click') {
                        rmv.call(layer, type, callback.hijacked || callback, capture);
                    } else {
                        rmv.call(layer, type, callback, capture);
                    }
                };

                layer.addEventListener = function(type, callback, capture) {
                    var adv = Node.prototype.addEventListener;
                    if (type === 'click') {
                        adv.call(layer, type, callback.hijacked || (callback.hijacked = function(event) {
                            if (!event.propagationStopped) {
                                callback(event);
                            }
                        }), capture);
                    } else {
                        adv.call(layer, type, callback, capture);
                    }
                };
            }

            // If a handler is already declared in the element's onclick attribute, it will be fired before
            // FastClick's onClick handler. Fix this by pulling out the user-defined handler function and
            // adding it as listener.
            if (typeof layer.onclick === 'function') {

                // Android browser on at least 3.2 requires a new reference to the function in layer.onclick
                // - the old one won't work if passed to addEventListener directly.
                oldOnClick = layer.onclick;
                layer.addEventListener('click', function(event) {
                    oldOnClick(event);
                }, false);
                layer.onclick = null;
            }
        }


        /**
         * Android requires exceptions.
         *
         * @type boolean
         */
        FastClick.prototype.deviceIsAndroid = navigator.userAgent.indexOf('Android') > 0;


        /**
         * iOS requires exceptions.
         *
         * @type boolean
         */
        FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent);


        /**
         * iOS 4 requires an exception for select elements.
         *
         * @type boolean
         */
        FastClick.prototype.deviceIsIOS4 = FastClick.prototype.deviceIsIOS && (/OS 4_\d(_\d)?/).test(navigator.userAgent);


        /**
         * iOS 6.0(+?) requires the target element to be manually derived
         *
         * @type boolean
         */
        FastClick.prototype.deviceIsIOSWithBadTarget = FastClick.prototype.deviceIsIOS && (/OS ([6-9]|\d{2})_\d/).test(navigator.userAgent);


        /**
         * Determine whether a given element requires a native click.
         *
         * @param {EventTarget|Element} target Target DOM element
         * @returns {boolean} Returns true if the element needs a native click
         */
        FastClick.prototype.needsClick = function(target) {
            'use strict';
            switch (target.nodeName.toLowerCase()) {

                // Don't send a synthetic click to disabled inputs (issue #62)
                case 'button':
                case 'select':
                case 'textarea':
                    if (target.disabled) {
                        return true;
                    }

                    break;
                case 'input':

                    // File inputs need real clicks on iOS 6 due to a browser bug (issue #68)
                    if ((this.deviceIsIOS && target.type === 'file') || target.disabled) {
                        return true;
                    }

                    break;
                case 'label':
                case 'video':
                    return true;
            }

            return (/\bneedsclick\b/).test(target.className);
        };


        /**
         * Determine whether a given element requires a call to focus to simulate click into element.
         *
         * @param {EventTarget|Element} target Target DOM element
         * @returns {boolean} Returns true if the element requires a call to focus to simulate native click.
         */
        FastClick.prototype.needsFocus = function(target) {
            'use strict';
            switch (target.nodeName.toLowerCase()) {
                case 'textarea':
                    return true;
                case 'select':
                    return !this.deviceIsAndroid;
                case 'input':
                    switch (target.type) {
                        case 'button':
                        case 'checkbox':
                        case 'file':
                        case 'image':
                        case 'radio':
                        case 'submit':
                            return false;
                    }

                    // No point in attempting to focus disabled inputs
                    return !target.disabled && !target.readOnly;
                default:
                    return (/\bneedsfocus\b/).test(target.className);
            }
        };


        /**
         * Send a click event to the specified element.
         *
         * @param {EventTarget|Element} targetElement
         * @param {Event} event
         */
        FastClick.prototype.sendClick = function(targetElement, event) {
            'use strict';
            var clickEvent, touch;

            // On some Android devices activeElement needs to be blurred otherwise the synthetic click will have no effect (#24)
            if (document.activeElement && document.activeElement !== targetElement) {
                document.activeElement.blur();
            }

            touch = event.changedTouches[0];

            // Synthesise a click event, with an extra attribute so it can be tracked
            clickEvent = document.createEvent('MouseEvents');
            clickEvent.initMouseEvent(this.determineEventType(targetElement), true, true, window, 1, touch.screenX, touch.screenY, touch.clientX, touch.clientY, false, false, false, false, 0, null);
            clickEvent.forwardedTouchEvent = true;
            targetElement.dispatchEvent(clickEvent);
        };

        FastClick.prototype.determineEventType = function(targetElement) {
            'use strict';

            //Issue #159: Android Chrome Select Box does not open with a synthetic click event
            if (this.deviceIsAndroid && targetElement.tagName.toLowerCase() === 'select') {
                return 'mousedown';
            }

            return 'click';
        };


        /**
         * @param {EventTarget|Element} targetElement
         */
        FastClick.prototype.focus = function(targetElement) {
            'use strict';
            var length;

            // Issue #160: on iOS 7, some input elements (e.g. date datetime) throw a vague TypeError on setSelectionRange. These elements don't have an integer value for the selectionStart and selectionEnd properties, but unfortunately that can't be used for detection because accessing the properties also throws a TypeError. Just check the type instead. Filed as Apple bug #15122724.
            if (this.deviceIsIOS && targetElement.setSelectionRange && targetElement.type.indexOf('date') !== 0 && targetElement.type !== 'time') {
                length = targetElement.value.length;
                targetElement.setSelectionRange(length, length);
            } else {
                targetElement.focus();
            }
        };


        /**
         * Check whether the given target element is a child of a scrollable layer and if so, set a flag on it.
         *
         * @param {EventTarget|Element} targetElement
         */
        FastClick.prototype.updateScrollParent = function(targetElement) {
            'use strict';
            var scrollParent, parentElement;

            scrollParent = targetElement.fastClickScrollParent;

            // Attempt to discover whether the target element is contained within a scrollable layer. Re-check if the
            // target element was moved to another parent.
            if (!scrollParent || !scrollParent.contains(targetElement)) {
                parentElement = targetElement;
                do {
                    if (parentElement.scrollHeight > parentElement.offsetHeight) {
                        scrollParent = parentElement;
                        targetElement.fastClickScrollParent = parentElement;
                        break;
                    }

                    parentElement = parentElement.parentElement;
                } while (parentElement);
            }

            // Always update the scroll top tracker if possible.
            if (scrollParent) {
                scrollParent.fastClickLastScrollTop = scrollParent.scrollTop;
            }
        };


        /**
         * @param {EventTarget} targetElement
         * @returns {Element|EventTarget}
         */
        FastClick.prototype.getTargetElementFromEventTarget = function(eventTarget) {
            'use strict';

            // On some older browsers (notably Safari on iOS 4.1 - see issue #56) the event target may be a text node.
            if (eventTarget.nodeType === Node.TEXT_NODE) {
                return eventTarget.parentNode;
            }

            return eventTarget;
        };


        /**
         * On touch start, record the position and scroll offset.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.onTouchStart = function(event) {
            'use strict';
            var targetElement, touch, selection;

            // Ignore multiple touches, otherwise pinch-to-zoom is prevented if both fingers are on the FastClick element (issue #111).
            if (event.targetTouches.length > 1) {
                return true;
            }

            targetElement = this.getTargetElementFromEventTarget(event.target);
            touch = event.targetTouches[0];

            if (this.deviceIsIOS) {

                // Only trusted events will deselect text on iOS (issue #49)
                selection = window.getSelection();
                if (selection.rangeCount && !selection.isCollapsed) {
                    return true;
                }

                if (!this.deviceIsIOS4) {

                    // Weird things happen on iOS when an alert or confirm dialog is opened from a click event callback (issue #23):
                    // when the user next taps anywhere else on the page, new touchstart and touchend events are dispatched
                    // with the same identifier as the touch event that previously triggered the click that triggered the alert.
                    // Sadly, there is an issue on iOS 4 that causes some normal touch events to have the same identifier as an
                    // immediately preceeding touch event (issue #52), so this fix is unavailable on that platform.
                    if (touch.identifier === this.lastTouchIdentifier) {
                        event.preventDefault();
                        return false;
                    }

                    this.lastTouchIdentifier = touch.identifier;

                    // If the target element is a child of a scrollable layer (using -webkit-overflow-scrolling: touch) and:
                    // 1) the user does a fling scroll on the scrollable layer
                    // 2) the user stops the fling scroll with another tap
                    // then the event.target of the last 'touchend' event will be the element that was under the user's finger
                    // when the fling scroll was started, causing FastClick to send a click event to that layer - unless a check
                    // is made to ensure that a parent layer was not scrolled before sending a synthetic click (issue #42).
                    this.updateScrollParent(targetElement);
                }
            }

            this.trackingClick = true;
            this.trackingClickStart = event.timeStamp;
            this.targetElement = targetElement;

            this.touchStartX = touch.pageX;
            this.touchStartY = touch.pageY;

            // Prevent phantom clicks on fast double-tap (issue #36)
            if ((event.timeStamp - this.lastClickTime) < 200) {
                event.preventDefault();
            }

            return true;
        };


        /**
         * Based on a touchmove event object, check whether the touch has moved past a boundary since it started.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.touchHasMoved = function(event) {
            'use strict';
            var touch = event.changedTouches[0], boundary = this.touchBoundary;

            if (Math.abs(touch.pageX - this.touchStartX) > boundary || Math.abs(touch.pageY - this.touchStartY) > boundary) {
                return true;
            }

            return false;
        };


        /**
         * Update the last position.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.onTouchMove = function(event) {
            'use strict';
            if (!this.trackingClick) {
                return true;
            }

            // If the touch has moved, cancel the click tracking
            if (this.targetElement !== this.getTargetElementFromEventTarget(event.target) || this.touchHasMoved(event)) {
                this.trackingClick = false;
                this.targetElement = null;
            }

            return true;
        };


        /**
         * Attempt to find the labelled control for the given label element.
         *
         * @param {EventTarget|HTMLLabelElement} labelElement
         * @returns {Element|null}
         */
        FastClick.prototype.findControl = function(labelElement) {
            'use strict';

            // Fast path for newer browsers supporting the HTML5 control attribute
            if (labelElement.control !== undefined) {
                return labelElement.control;
            }

            // All browsers under test that support touch events also support the HTML5 htmlFor attribute
            if (labelElement.htmlFor) {
                return document.getElementById(labelElement.htmlFor);
            }

            // If no for attribute exists, attempt to retrieve the first labellable descendant element
            // the list of which is defined here: http://www.w3.org/TR/html5/forms.html#category-label
            return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea');
        };


        /**
         * On touch end, determine whether to send a click event at once.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.onTouchEnd = function(event) {
            'use strict';
            var forElement, trackingClickStart, targetTagName, scrollParent, touch, targetElement = this.targetElement;

            if (!this.trackingClick) {
                return true;
            }

            // Prevent phantom clicks on fast double-tap (issue #36)
            if ((event.timeStamp - this.lastClickTime) < 200) {
                this.cancelNextClick = true;
                return true;
            }

            // Reset to prevent wrong click cancel on input (issue #156).
            this.cancelNextClick = false;

            this.lastClickTime = event.timeStamp;

            trackingClickStart = this.trackingClickStart;
            this.trackingClick = false;
            this.trackingClickStart = 0;

            // On some iOS devices, the targetElement supplied with the event is invalid if the layer
            // is performing a transition or scroll, and has to be re-detected manually. Note that
            // for this to function correctly, it must be called *after* the event target is checked!
            // See issue #57; also filed as rdar://13048589 .
            if (this.deviceIsIOSWithBadTarget) {
                touch = event.changedTouches[0];

                // In certain cases arguments of elementFromPoint can be negative, so prevent setting targetElement to null
                targetElement = document.elementFromPoint(touch.pageX - window.pageXOffset, touch.pageY - window.pageYOffset) || targetElement;
                targetElement.fastClickScrollParent = this.targetElement.fastClickScrollParent;
            }

            targetTagName = targetElement.tagName.toLowerCase();
            if (targetTagName === 'label') {
                forElement = this.findControl(targetElement);
                if (forElement) {
                    this.focus(targetElement);
                    if (this.deviceIsAndroid) {
                        return false;
                    }

                    targetElement = forElement;
                }
            } else if (this.needsFocus(targetElement)) {

                // Case 1: If the touch started a while ago (best guess is 100ms based on tests for issue #36) then focus will be triggered anyway. Return early and unset the target element reference so that the subsequent click will be allowed through.
                // Case 2: Without this exception for input elements tapped when the document is contained in an iframe, then any inputted text won't be visible even though the value attribute is updated as the user types (issue #37).
                if ((event.timeStamp - trackingClickStart) > 100 || (this.deviceIsIOS && window.top !== window && targetTagName === 'input')) {
                    this.targetElement = null;
                    return false;
                }

                this.focus(targetElement);

                // Select elements need the event to go through on iOS 4, otherwise the selector menu won't open.
                if (!this.deviceIsIOS4 || targetTagName !== 'select') {
                    this.targetElement = null;
                    event.preventDefault();
                }

                return false;
            }

            if (this.deviceIsIOS && !this.deviceIsIOS4) {

                // Don't send a synthetic click event if the target element is contained within a parent layer that was scrolled
                // and this tap is being used to stop the scrolling (usually initiated by a fling - issue #42).
                scrollParent = targetElement.fastClickScrollParent;
                if (scrollParent && scrollParent.fastClickLastScrollTop !== scrollParent.scrollTop) {
                    return true;
                }
            }

            // Prevent the actual click from going though - unless the target node is marked as requiring
            // real clicks or if it is in the whitelist in which case only non-programmatic clicks are permitted.
            if (!this.needsClick(targetElement)) {
                event.preventDefault();
                this.sendClick(targetElement, event);
            }

            return false;
        };


        /**
         * On touch cancel, stop tracking the click.
         *
         * @returns {void}
         */
        FastClick.prototype.onTouchCancel = function() {
            'use strict';
            this.trackingClick = false;
            this.targetElement = null;
        };


        /**
         * Determine mouse events which should be permitted.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.onMouse = function(event) {
            'use strict';

            // If a target element was never set (because a touch event was never fired) allow the event
            if (!this.targetElement) {
                return true;
            }

            if (event.forwardedTouchEvent) {
                return true;
            }

            // Programmatically generated events targeting a specific element should be permitted
            if (!event.cancelable) {
                return true;
            }

            // Derive and check the target element to see whether the mouse event needs to be permitted;
            // unless explicitly enabled, prevent non-touch click events from triggering actions,
            // to prevent ghost/doubleclicks.
            if (!this.needsClick(this.targetElement) || this.cancelNextClick) {

                // Prevent any user-added listeners declared on FastClick element from being fired.
                if (event.stopImmediatePropagation) {
                    event.stopImmediatePropagation();
                } else {

                    // Part of the hack for browsers that don't support Event#stopImmediatePropagation (e.g. Android 2)
                    event.propagationStopped = true;
                }

                // Cancel the event
                event.stopPropagation();
                event.preventDefault();

                return false;
            }

            // If the mouse event is permitted, return true for the action to go through.
            return true;
        };


        /**
         * On actual clicks, determine whether this is a touch-generated click, a click action occurring
         * naturally after a delay after a touch (which needs to be cancelled to avoid duplication), or
         * an actual click which should be permitted.
         *
         * @param {Event} event
         * @returns {boolean}
         */
        FastClick.prototype.onClick = function(event) {
            'use strict';
            var permitted;

            // It's possible for another FastClick-like library delivered with third-party code to fire a click event before FastClick does (issue #44). In that case, set the click-tracking flag back to false and return early. This will cause onTouchEnd to return early.
            if (this.trackingClick) {
                this.targetElement = null;
                this.trackingClick = false;
                return true;
            }

            // Very odd behaviour on iOS (issue #18): if a submit element is present inside a form and the user hits enter in the iOS simulator or clicks the Go button on the pop-up OS keyboard the a kind of 'fake' click event will be triggered with the submit-type input element as the target.
            if (event.target.type === 'submit' && event.detail === 0) {
                return true;
            }

            permitted = this.onMouse(event);

            // Only unset targetElement if the click is not permitted. This will ensure that the check for !targetElement in onMouse fails and the browser's click doesn't go through.
            if (!permitted) {
                this.targetElement = null;
            }

            // If clicks are permitted, return true for the action to go through.
            return permitted;
        };


        /**
         * Remove all FastClick's event listeners.
         *
         * @returns {void}
         */
        FastClick.prototype.destroy = function() {
            'use strict';
            var layer = this.layer;

            if (this.deviceIsAndroid) {
                layer.removeEventListener('mouseover', this.onMouse, true);
                layer.removeEventListener('mousedown', this.onMouse, true);
                layer.removeEventListener('mouseup', this.onMouse, true);
            }

            layer.removeEventListener('click', this.onClick, true);
            layer.removeEventListener('touchstart', this.onTouchStart, false);
            layer.removeEventListener('touchmove', this.onTouchMove, false);
            layer.removeEventListener('touchend', this.onTouchEnd, false);
            layer.removeEventListener('touchcancel', this.onTouchCancel, false);
        };


        /**
         * Check whether FastClick is needed.
         *
         * @param {Element} layer The layer to listen on
         */
        FastClick.notNeeded = function(layer) {
            'use strict';
            var metaViewport;
            var chromeVersion;

            // Devices that don't support touch don't need FastClick
            if (typeof window.ontouchstart === 'undefined') {
                return true;
            }

            // Chrome version - zero for other browsers
            chromeVersion = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [,0])[1];

            if (chromeVersion) {

                if (FastClick.prototype.deviceIsAndroid) {
                    metaViewport = document.querySelector('meta[name=viewport]');

                    if (metaViewport) {
                        // Chrome on Android with user-scalable="no" doesn't need FastClick (issue #89)
                        if (metaViewport.content.indexOf('user-scalable=no') !== -1) {
                            return true;
                        }
                        // Chrome 32 and above with width=device-width or less don't need FastClick
                        if (chromeVersion > 31 && window.innerWidth <= window.screen.width) {
                            return true;
                        }
                    }

                    // Chrome desktop doesn't need FastClick (issue #15)
                } else {
                    return true;
                }
            }

            // IE10 with -ms-touch-action: none, which disables double-tap-to-zoom (issue #97)
            if (layer.style.msTouchAction === 'none') {
                return true;
            }

            return false;
        };


        /**
         * Factory method for creating a FastClick object
         *
         * @param {Element} layer The layer to listen on
         */
        FastClick.attach = function(layer) {
            'use strict';
            return new FastClick(layer);
        };


        if (typeof define !== 'undefined' && define.amd) {

            // AMD. Register as an anonymous module.
            define(function() {
                'use strict';
                return FastClick;
            });
        } else if (typeof module !== 'undefined' && module.exports) {
            module.exports = FastClick.attach;
            module.exports.FastClick = FastClick;
        } else {
            window.FastClick = FastClick;
        }

    });

    require.register("component~indexof@0.0.3", function (exports, module) {
        module.exports = function(arr, obj){
            if (arr.indexOf) return arr.indexOf(obj);
            for (var i = 0; i < arr.length; ++i) {
                if (arr[i] === obj) return i;
            }
            return -1;
        };
    });

    require.register("component~classes@1.2.1", function (exports, module) {
        /**
         * Module dependencies.
         */

        var index = require('component~indexof@0.0.3');

        /**
         * Whitespace regexp.
         */

        var re = /\s+/;

        /**
         * toString reference.
         */

        var toString = Object.prototype.toString;

        /**
         * Wrap `el` in a `ClassList`.
         *
         * @param {Element} el
         * @return {ClassList}
         * @api public
         */

        module.exports = function(el){
            return new ClassList(el);
        };

        /**
         * Initialize a new ClassList for `el`.
         *
         * @param {Element} el
         * @api private
         */

        function ClassList(el) {
            if (!el) throw new Error('A DOM element reference is required');
            this.el = el;
            this.list = el.classList;
        }

        /**
         * Add class `name` if not already present.
         *
         * @param {String} name
         * @return {ClassList}
         * @api public
         */

        ClassList.prototype.add = function(name){
            // classList
            if (this.list) {
                this.list.add(name);
                return this;
            }

            // fallback
            var arr = this.array();
            var i = index(arr, name);
            if (!~i) arr.push(name);
            this.el.className = arr.join(' ');
            return this;
        };

        /**
         * Remove class `name` when present, or
         * pass a regular expression to remove
         * any which match.
         *
         * @param {String|RegExp} name
         * @return {ClassList}
         * @api public
         */

        ClassList.prototype.remove = function(name){
            if ('[object RegExp]' == toString.call(name)) {
                return this.removeMatching(name);
            }

            // classList
            if (this.list) {
                this.list.remove(name);
                return this;
            }

            // fallback
            var arr = this.array();
            var i = index(arr, name);
            if (~i) arr.splice(i, 1);
            this.el.className = arr.join(' ');
            return this;
        };

        /**
         * Remove all classes matching `re`.
         *
         * @param {RegExp} re
         * @return {ClassList}
         * @api private
         */

        ClassList.prototype.removeMatching = function(re){
            var arr = this.array();
            for (var i = 0; i < arr.length; i++) {
                if (re.test(arr[i])) {
                    this.remove(arr[i]);
                }
            }
            return this;
        };

        /**
         * Toggle class `name`, can force state via `force`.
         *
         * For browsers that support classList, but do not support `force` yet,
         * the mistake will be detected and corrected.
         *
         * @param {String} name
         * @param {Boolean} force
         * @return {ClassList}
         * @api public
         */

        ClassList.prototype.toggle = function(name, force){
            // classList
            if (this.list) {
                if ("undefined" !== typeof force) {
                    if (force !== this.list.toggle(name, force)) {
                        this.list.toggle(name); // toggle again to correct
                    }
                } else {
                    this.list.toggle(name);
                }
                return this;
            }

            // fallback
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

        /**
         * Return an array of classes.
         *
         * @return {Array}
         * @api public
         */

        ClassList.prototype.array = function(){
            var str = this.el.className.replace(/^\s+|\s+$/g, '');
            var arr = str.split(re);
            if ('' === arr[0]) arr.shift();
            return arr;
        };

        /**
         * Check if class `name` is present.
         *
         * @param {String} name
         * @return {ClassList}
         * @api public
         */

        ClassList.prototype.has =
            ClassList.prototype.contains = function(name){
                return this.list
                    ? this.list.contains(name)
                    : !! ~index(this.array(), name);
            };

    });

    require.register("component~event@0.1.4", function (exports, module) {
        var bind = window.addEventListener ? 'addEventListener' : 'attachEvent',
            unbind = window.removeEventListener ? 'removeEventListener' : 'detachEvent',
            prefix = bind !== 'addEventListener' ? 'on' : '';

        /**
         * Bind `el` event `type` to `fn`.
         *
         * @param {Element} el
         * @param {String} type
         * @param {Function} fn
         * @param {Boolean} capture
         * @return {Function}
         * @api public
         */

        exports.bind = function(el, type, fn, capture){
            el[bind](prefix + type, fn, capture || false);
            return fn;
        };

        /**
         * Unbind `el` event `type`'s callback `fn`.
         *
         * @param {Element} el
         * @param {String} type
         * @param {Function} fn
         * @param {Boolean} capture
         * @return {Function}
         * @api public
         */

        exports.unbind = function(el, type, fn, capture){
            el[unbind](prefix + type, fn, capture || false);
            return fn;
        };
    });

    require.register("component~query@0.0.3", function (exports, module) {
        function one(selector, el) {
            return el.querySelector(selector);
        }

        exports = module.exports = function(selector, el){
            el = el || document;
            return one(selector, el);
        };

        exports.all = function(selector, el){
            el = el || document;
            return el.querySelectorAll(selector);
        };

        exports.engine = function(obj){
            if (!obj.one) throw new Error('.one callback required');
            if (!obj.all) throw new Error('.all callback required');
            one = obj.one;
            exports.all = obj.all;
            return exports;
        };

    });

    require.register("component~matches-selector@0.1.5", function (exports, module) {
        /**
         * Module dependencies.
         */

        var query = require('component~query@0.0.3');

        /**
         * Element prototype.
         */

        var proto = Element.prototype;

        /**
         * Vendor function.
         */

        var vendor = proto.matches
            || proto.webkitMatchesSelector
            || proto.mozMatchesSelector
            || proto.msMatchesSelector
            || proto.oMatchesSelector;

        /**
         * Expose `match()`.
         */

        module.exports = match;

        /**
         * Match `el` to `selector`.
         *
         * @param {Element} el
         * @param {String} selector
         * @return {Boolean}
         * @api public
         */

        function match(el, selector) {
            if (!el || el.nodeType !== 1) return false;
            if (vendor) return vendor.call(el, selector);
            var nodes = query.all(selector, el.parentNode);
            for (var i = 0; i < nodes.length; ++i) {
                if (nodes[i] == el) return true;
            }
            return false;
        }

    });

    require.register("component~closest@0.1.4", function (exports, module) {
        var matches = require('component~matches-selector@0.1.5')

        module.exports = function (element, selector, checkYoSelf, root) {
            element = checkYoSelf ? {parentNode: element} : element

            root = root || document

            // Make sure `element !== document` and `element != null`
            // otherwise we get an illegal invocation
            while ((element = element.parentNode) && element !== document) {
                if (matches(element, selector))
                    return element
                // After `matches` on the edge case that
                // the selector matches the root
                // (when the root is not the document)
                if (element === root)
                    return
            }
        }

    });

    require.register("component~delegate@0.2.3", function (exports, module) {
        /**
         * Module dependencies.
         */

        var closest = require('component~closest@0.1.4')
            , event = require('component~event@0.1.4');

        /**
         * Delegate event `type` to `selector`
         * and invoke `fn(e)`. A callback function
         * is returned which may be passed to `.unbind()`.
         *
         * @param {Element} el
         * @param {String} selector
         * @param {String} type
         * @param {Function} fn
         * @param {Boolean} capture
         * @return {Function}
         * @api public
         */

        exports.bind = function(el, selector, type, fn, capture){
            return event.bind(el, type, function(e){
                var target = e.target || e.srcElement;
                e.delegateTarget = closest(target, selector, true, el);
                if (e.delegateTarget) fn.call(el, e);
            }, capture);
        };

        /**
         * Unbind event `type`'s callback `fn`.
         *
         * @param {Element} el
         * @param {String} type
         * @param {Function} fn
         * @param {Boolean} capture
         * @api public
         */

        exports.unbind = function(el, type, fn, capture){
            event.unbind(el, type, fn, capture);
        };

    });

    require.register("component~events@1.0.9", function (exports, module) {

        /**
         * Module dependencies.
         */

        var events = require('component~event@0.1.4');
        var delegate = require('component~delegate@0.2.3');

        /**
         * Expose `Events`.
         */

        module.exports = Events;

        /**
         * Initialize an `Events` with the given
         * `el` object which events will be bound to,
         * and the `obj` which will receive method calls.
         *
         * @param {Object} el
         * @param {Object} obj
         * @api public
         */

        function Events(el, obj) {
            if (!(this instanceof Events)) return new Events(el, obj);
            if (!el) throw new Error('element required');
            if (!obj) throw new Error('object required');
            this.el = el;
            this.obj = obj;
            this._events = {};
        }

        /**
         * Subscription helper.
         */

        Events.prototype.sub = function(event, method, cb){
            this._events[event] = this._events[event] || {};
            this._events[event][method] = cb;
        };

        /**
         * Bind to `event` with optional `method` name.
         * When `method` is undefined it becomes `event`
         * with the "on" prefix.
         *
         * Examples:
         *
         *  Direct event handling:
         *
         *    events.bind('click') // implies "onclick"
         *    events.bind('click', 'remove')
         *    events.bind('click', 'sort', 'asc')
         *
         *  Delegated event handling:
         *
         *    events.bind('click li > a')
         *    events.bind('click li > a', 'remove')
         *    events.bind('click a.sort-ascending', 'sort', 'asc')
         *    events.bind('click a.sort-descending', 'sort', 'desc')
         *
         * @param {String} event
         * @param {String|function} [method]
         * @return {Function} callback
         * @api public
         */

        Events.prototype.bind = function(event, method){
            var e = parse(event);
            var el = this.el;
            var obj = this.obj;
            var name = e.name;
            var method = method || 'on' + name;
            var args = [].slice.call(arguments, 2);

            // callback
            function cb(){
                var a = [].slice.call(arguments).concat(args);
                obj[method].apply(obj, a);
            }

            // bind
            if (e.selector) {
                cb = delegate.bind(el, e.selector, name, cb);
            } else {
                events.bind(el, name, cb);
            }

            // subscription for unbinding
            this.sub(name, method, cb);

            return cb;
        };

        /**
         * Unbind a single binding, all bindings for `event`,
         * or all bindings within the manager.
         *
         * Examples:
         *
         *  Unbind direct handlers:
         *
         *     events.unbind('click', 'remove')
         *     events.unbind('click')
         *     events.unbind()
         *
         * Unbind delegate handlers:
         *
         *     events.unbind('click', 'remove')
         *     events.unbind('click')
         *     events.unbind()
         *
         * @param {String|Function} [event]
         * @param {String|Function} [method]
         * @api public
         */

        Events.prototype.unbind = function(event, method){
            if (0 == arguments.length) return this.unbindAll();
            if (1 == arguments.length) return this.unbindAllOf(event);

            // no bindings for this event
            var bindings = this._events[event];
            if (!bindings) return;

            // no bindings for this method
            var cb = bindings[method];
            if (!cb) return;

            events.unbind(this.el, event, cb);
        };

        /**
         * Unbind all events.
         *
         * @api private
         */

        Events.prototype.unbindAll = function(){
            for (var event in this._events) {
                this.unbindAllOf(event);
            }
        };

        /**
         * Unbind all events for `event`.
         *
         * @param {String} event
         * @api private
         */

        Events.prototype.unbindAllOf = function(event){
            var bindings = this._events[event];
            if (!bindings) return;

            for (var method in bindings) {
                this.unbind(event, method);
            }
        };

        /**
         * Parse `event`.
         *
         * @param {String} event
         * @return {Object}
         * @api private
         */

        function parse(event) {
            var parts = event.split(/ +/);
            return {
                name: parts.shift(),
                selector: parts.join(' ')
            }
        }

    });

    require.register("switchery", function (exports, module) {
        /**
         * Switchery 0.8.1
         * http://abpetkov.github.io/switchery/
         *
         * Authored by Alexander Petkov
         * https://github.com/abpetkov
         *
         * Copyright 2013-2015, Alexander Petkov
         * License: The MIT License (MIT)
         * http://opensource.org/licenses/MIT
         *
         */

        /**
         * External dependencies.
         */

        var transitionize = require('abpetkov~transitionize@0.0.3')
            , fastclick = require('ftlabs~fastclick@v0.6.11')
            , classes = require('component~classes@1.2.1')
            , events = require('component~events@1.0.9');

        /**
         * Expose `Switchery`.
         */

        module.exports = Switchery;

        /**
         * Set Switchery default values.
         *
         * @api public
         */

        var defaults = {
            color             : '#64bd63'
            , secondaryColor    : '#dfdfdf'
            , jackColor         : '#fff'
            , jackSecondaryColor: null
            , className         : 'switchery'
            , disabled          : false
            , disabledOpacity   : 0.5
            , speed             : '0.4s'
            , size              : 'default'
        };

        /**
         * Create Switchery object.
         *
         * @param {Object} element
         * @param {Object} options
         * @api public
         */

        function Switchery(element, options) {
            if (!(this instanceof Switchery)) return new Switchery(element, options);

            this.element = element;
            this.options = options || {};

            for (var i in defaults) {
                if (this.options[i] == null) {
                    this.options[i] = defaults[i];
                }
            }

            if (this.element != null && this.element.type == 'checkbox') this.init();
            if (this.isDisabled() === true) this.disable();
        }

        /**
         * Hide the target element.
         *
         * @api private
         */

        Switchery.prototype.hide = function() {
            this.element.style.display = 'none';
        };

        /**
         * Show custom switch after the target element.
         *
         * @api private
         */

        Switchery.prototype.show = function() {
            var switcher = this.create();
            this.insertAfter(this.element, switcher);
        };

        /**
         * Create custom switch.
         *
         * @returns {Object} this.switcher
         * @api private
         */

        Switchery.prototype.create = function() {
            this.switcher = document.createElement('span');
            this.jack = document.createElement('small');
            this.switcher.appendChild(this.jack);
            this.switcher.className = this.options.className;
            this.events = events(this.switcher, this);

            return this.switcher;
        };

        /**
         * Insert after element after another element.
         *
         * @param {Object} reference
         * @param {Object} target
         * @api private
         */

        Switchery.prototype.insertAfter = function(reference, target) {
            reference.parentNode.insertBefore(target, reference.nextSibling);
        };

        /**
         * Set switch jack proper position.
         *
         * @param {Boolean} clicked - we need this in order to uncheck the input when the switch is clicked
         * @api private
         */

        Switchery.prototype.setPosition = function (clicked) {
            var checked = this.isChecked()
                , switcher = this.switcher
                , jack = this.jack;

            if (clicked && checked) checked = false;
            else if (clicked && !checked) checked = true;

            if (checked === true) {
                this.element.checked = true;

                if (window.getComputedStyle) jack.style.left = parseInt(window.getComputedStyle(switcher).width) - parseInt(window.getComputedStyle(jack).width) + 'px';
                else jack.style.left = parseInt(switcher.currentStyle['width']) - parseInt(jack.currentStyle['width']) + 'px';

                if (this.options.color) this.colorize();
                this.setSpeed();
            } else {
                jack.style.left = 0;
                this.element.checked = false;
                this.switcher.style.boxShadow = 'inset 0 0 0 0 ' + this.options.secondaryColor;
                this.switcher.style.borderColor = this.options.secondaryColor;
                this.switcher.style.backgroundColor = (this.options.secondaryColor !== defaults.secondaryColor) ? this.options.secondaryColor : '#fff';
                this.jack.style.backgroundColor = (this.options.jackSecondaryColor !== this.options.jackColor) ? this.options.jackSecondaryColor : this.options.jackColor;
                this.setSpeed();
            }
        };

        /**
         * Set speed.
         *
         * @api private
         */

        Switchery.prototype.setSpeed = function() {
            var switcherProp = {}
                , jackProp = {
                'background-color': this.options.speed
                , 'left': this.options.speed.replace(/[a-z]/, '') / 2 + 's'
            };

            if (this.isChecked()) {
                switcherProp = {
                    'border': this.options.speed
                    , 'box-shadow': this.options.speed
                    , 'background-color': this.options.speed.replace(/[a-z]/, '') * 3 + 's'
                };
            } else {
                switcherProp = {
                    'border': this.options.speed
                    , 'box-shadow': this.options.speed
                };
            }

            transitionize(this.switcher, switcherProp);
            transitionize(this.jack, jackProp);
        };

        /**
         * Set switch size.
         *
         * @api private
         */

        Switchery.prototype.setSize = function() {
            var small = 'switchery-small'
                , normal = 'switchery-default'
                , large = 'switchery-large';

            switch (this.options.size) {
                case 'small':
                    classes(this.switcher).add(small)
                    break;
                case 'large':
                    classes(this.switcher).add(large)
                    break;
                default:
                    classes(this.switcher).add(normal)
                    break;
            }
        };

        /**
         * Set switch color.
         *
         * @api private
         */

        Switchery.prototype.colorize = function() {
            var switcherHeight = this.switcher.offsetHeight / 2;

            this.switcher.style.backgroundColor = this.options.color;
            this.switcher.style.borderColor = this.options.color;
            this.switcher.style.boxShadow = 'inset 0 0 0 ' + switcherHeight + 'px ' + this.options.color;
            this.jack.style.backgroundColor = this.options.jackColor;
        };

        /**
         * Handle the onchange event.
         *
         * @param {Boolean} state
         * @api private
         */

        Switchery.prototype.handleOnchange = function(state) {
            if (document.dispatchEvent) {
                var event = document.createEvent('HTMLEvents');
                event.initEvent('change', true, true);
                this.element.dispatchEvent(event);
            } else {
                this.element.fireEvent('onchange');
            }
        };

        /**
         * Handle the native input element state change.
         * A `change` event must be fired in order to detect the change.
         *
         * @api private
         */

        Switchery.prototype.handleChange = function() {
            var self = this
                , el = this.element;

            if (el.addEventListener) {
                el.addEventListener('change', function() {
                    self.setPosition();
                });
            } else {
                el.attachEvent('onchange', function() {
                    self.setPosition();
                });
            }
        };

        /**
         * Handle the switch click event.
         *
         * @api private
         */

        Switchery.prototype.handleClick = function() {
            var switcher = this.switcher;

            fastclick(switcher);
            this.events.bind('click', 'bindClick');
        };

        /**
         * Attach all methods that need to happen on switcher click.
         *
         * @api private
         */

        Switchery.prototype.bindClick = function() {
            var parent = this.element.parentNode.tagName.toLowerCase()
                , labelParent = (parent === 'label') ? false : true;

            this.setPosition(labelParent);
            this.handleOnchange(this.element.checked);
        };

        /**
         * Mark an individual switch as already handled.
         *
         * @api private
         */

        Switchery.prototype.markAsSwitched = function() {
            this.element.setAttribute('data-switchery', true);
        };

        /**
         * Check if an individual switch is already handled.
         *
         * @api private
         */

        Switchery.prototype.markedAsSwitched = function() {
            return this.element.getAttribute('data-switchery');
        };

        /**
         * Initialize Switchery.
         *
         * @api private
         */

        Switchery.prototype.init = function() {
            this.hide();
            this.show();
            this.setSize();
            this.setPosition();
            this.markAsSwitched();
            this.handleChange();
            this.handleClick();
        };

        /**
         * See if input is checked.
         *
         * @returns {Boolean}
         * @api public
         */

        Switchery.prototype.isChecked = function() {
            return this.element.checked;
        };

        /**
         * See if switcher should be disabled.
         *
         * @returns {Boolean}
         * @api public
         */

        Switchery.prototype.isDisabled = function() {
            return this.options.disabled || this.element.disabled || this.element.readOnly;
        };

        /**
         * Destroy all event handlers attached to the switch.
         *
         * @api public
         */

        Switchery.prototype.destroy = function() {
            this.events.unbind();
        };

        /**
         * Enable disabled switch element.
         *
         * @api public
         */

        Switchery.prototype.enable = function() {
            if (!this.options.disabled) return;
            if (this.options.disabled) this.options.disabled = false;
            if (this.element.disabled) this.element.disabled = false;
            if (this.element.readOnly) this.element.readOnly = false;
            this.switcher.style.opacity = 1;
            this.events.bind('click', 'bindClick');
        };

        /**
         * Disable switch element.
         *
         * @api public
         */

        Switchery.prototype.disable = function() {
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
        define("Switchery", [], function(){ return require("switchery"); });
    } else {
        (this || window)["Switchery"] = require("switchery");
    }
})();


/* **********************************************
     Begin prism-core.js
********************************************** */

var _self = (typeof window !== 'undefined')
    ? window   // if in browser
    : (
        (typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
            ? self // if in worker
            : {}   // if in node js
    );

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 * MIT license http://www.opensource.org/licenses/mit-license.php/
 * @author Lea Verou http://lea.verou.me
 */

var Prism = (function(){

// Private helper vars
    var lang = /\blang(?:uage)?-([\w-]+)\b/i;
    var uniqueId = 0;

    var _ = _self.Prism = {
        manual: _self.Prism && _self.Prism.manual,
        disableWorkerMessageHandler: _self.Prism && _self.Prism.disableWorkerMessageHandler,
        util: {
            encode: function (tokens) {
                if (tokens instanceof Token) {
                    return new Token(tokens.type, _.util.encode(tokens.content), tokens.alias);
                } else if (_.util.type(tokens) === 'Array') {
                    return tokens.map(_.util.encode);
                } else {
                    return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
                }
            },

            type: function (o) {
                return Object.prototype.toString.call(o).match(/\[object (\w+)\]/)[1];
            },

            objId: function (obj) {
                if (!obj['__id']) {
                    Object.defineProperty(obj, '__id', { value: ++uniqueId });
                }
                return obj['__id'];
            },

            // Deep clone a language definition (e.g. to extend it)
            clone: function (o, visited) {
                var type = _.util.type(o);
                visited = visited || {};

                switch (type) {
                    case 'Object':
                        if (visited[_.util.objId(o)]) {
                            return visited[_.util.objId(o)];
                        }
                        var clone = {};
                        visited[_.util.objId(o)] = clone;

                        for (var key in o) {
                            if (o.hasOwnProperty(key)) {
                                clone[key] = _.util.clone(o[key], visited);
                            }
                        }

                        return clone;

                    case 'Array':
                        if (visited[_.util.objId(o)]) {
                            return visited[_.util.objId(o)];
                        }
                        var clone = [];
                        visited[_.util.objId(o)] = clone;

                        o.forEach(function (v, i) {
                            clone[i] = _.util.clone(v, visited);
                        });

                        return clone;
                }

                return o;
            }
        },

        languages: {
            extend: function (id, redef) {
                var lang = _.util.clone(_.languages[id]);

                for (var key in redef) {
                    lang[key] = redef[key];
                }

                return lang;
            },

            /**
             * Insert a token before another token in a language literal
             * As this needs to recreate the object (we cannot actually insert before keys in object literals),
             * we cannot just provide an object, we need anobject and a key.
             * @param inside The key (or language id) of the parent
             * @param before The key to insert before. If not provided, the function appends instead.
             * @param insert Object with the key/value pairs to insert
             * @param root The object that contains `inside`. If equal to Prism.languages, it can be omitted.
             */
            insertBefore: function (inside, before, insert, root) {
                root = root || _.languages;
                var grammar = root[inside];

                if (arguments.length == 2) {
                    insert = arguments[1];

                    for (var newToken in insert) {
                        if (insert.hasOwnProperty(newToken)) {
                            grammar[newToken] = insert[newToken];
                        }
                    }

                    return grammar;
                }

                var ret = {};

                for (var token in grammar) {

                    if (grammar.hasOwnProperty(token)) {

                        if (token == before) {

                            for (var newToken in insert) {

                                if (insert.hasOwnProperty(newToken)) {
                                    ret[newToken] = insert[newToken];
                                }
                            }
                        }

                        ret[token] = grammar[token];
                    }
                }

                // Update references in other language definitions
                _.languages.DFS(_.languages, function(key, value) {
                    if (value === root[inside] && key != inside) {
                        this[key] = ret;
                    }
                });

                return root[inside] = ret;
            },

            // Traverse a language definition with Depth First Search
            DFS: function(o, callback, type, visited) {
                visited = visited || {};
                for (var i in o) {
                    if (o.hasOwnProperty(i)) {
                        callback.call(o, i, o[i], type || i);

                        if (_.util.type(o[i]) === 'Object' && !visited[_.util.objId(o[i])]) {
                            visited[_.util.objId(o[i])] = true;
                            _.languages.DFS(o[i], callback, null, visited);
                        }
                        else if (_.util.type(o[i]) === 'Array' && !visited[_.util.objId(o[i])]) {
                            visited[_.util.objId(o[i])] = true;
                            _.languages.DFS(o[i], callback, i, visited);
                        }
                    }
                }
            }
        },
        plugins: {},

        highlightAll: function(async, callback) {
            _.highlightAllUnder(document, async, callback);
        },

        highlightAllUnder: function(container, async, callback) {
            var env = {
                callback: callback,
                selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
            };

            _.hooks.run("before-highlightall", env);

            var elements = env.elements || container.querySelectorAll(env.selector);

            for (var i=0, element; element = elements[i++];) {
                _.highlightElement(element, async === true, env.callback);
            }
        },

        highlightElement: function(element, async, callback) {
            // Find language
            var language, grammar, parent = element;

            while (parent && !lang.test(parent.className)) {
                parent = parent.parentNode;
            }

            if (parent) {
                language = (parent.className.match(lang) || [,''])[1].toLowerCase();
                grammar = _.languages[language];
            }

            // Set language on the element, if not present
            element.className = element.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;

            if (element.parentNode) {
                // Set language on the parent, for styling
                parent = element.parentNode;

                if (/pre/i.test(parent.nodeName)) {
                    parent.className = parent.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;
                }
            }

            var code = element.textContent;

            var env = {
                element: element,
                language: language,
                grammar: grammar,
                code: code
            };

            _.hooks.run('before-sanity-check', env);

            if (!env.code || !env.grammar) {
                if (env.code) {
                    _.hooks.run('before-highlight', env);
                    env.element.textContent = env.code;
                    _.hooks.run('after-highlight', env);
                }
                _.hooks.run('complete', env);
                return;
            }

            _.hooks.run('before-highlight', env);

            if (async && _self.Worker) {
                var worker = new Worker(_.filename);

                worker.onmessage = function(evt) {
                    env.highlightedCode = evt.data;

                    _.hooks.run('before-insert', env);

                    env.element.innerHTML = env.highlightedCode;

                    callback && callback.call(env.element);
                    _.hooks.run('after-highlight', env);
                    _.hooks.run('complete', env);
                };

                worker.postMessage(JSON.stringify({
                    language: env.language,
                    code: env.code,
                    immediateClose: true
                }));
            }
            else {
                env.highlightedCode = _.highlight(env.code, env.grammar, env.language);

                _.hooks.run('before-insert', env);

                env.element.innerHTML = env.highlightedCode;

                callback && callback.call(element);

                _.hooks.run('after-highlight', env);
                _.hooks.run('complete', env);
            }
        },

        highlight: function (text, grammar, language) {
            var env = {
                code: text,
                grammar: grammar,
                language: language
            };
            _.hooks.run('before-tokenize', env);
            env.tokens = _.tokenize(env.code, env.grammar);
            _.hooks.run('after-tokenize', env);
            return Token.stringify(_.util.encode(env.tokens), env.language);
        },

        matchGrammar: function (text, strarr, grammar, index, startPos, oneshot, target) {
            var Token = _.Token;

            for (var token in grammar) {
                if(!grammar.hasOwnProperty(token) || !grammar[token]) {
                    continue;
                }

                if (token == target) {
                    return;
                }

                var patterns = grammar[token];
                patterns = (_.util.type(patterns) === "Array") ? patterns : [patterns];

                for (var j = 0; j < patterns.length; ++j) {
                    var pattern = patterns[j],
                        inside = pattern.inside,
                        lookbehind = !!pattern.lookbehind,
                        greedy = !!pattern.greedy,
                        lookbehindLength = 0,
                        alias = pattern.alias;

                    if (greedy && !pattern.pattern.global) {
                        // Without the global flag, lastIndex won't work
                        var flags = pattern.pattern.toString().match(/[imuy]*$/)[0];
                        pattern.pattern = RegExp(pattern.pattern.source, flags + "g");
                    }

                    pattern = pattern.pattern || pattern;

                    // Don’t cache length as it changes during the loop
                    for (var i = index, pos = startPos; i < strarr.length; pos += strarr[i].length, ++i) {

                        var str = strarr[i];

                        if (strarr.length > text.length) {
                            // Something went terribly wrong, ABORT, ABORT!
                            return;
                        }

                        if (str instanceof Token) {
                            continue;
                        }

                        if (greedy && i != strarr.length - 1) {
                            pattern.lastIndex = pos;
                            var match = pattern.exec(text);
                            if (!match) {
                                break;
                            }

                            var from = match.index + (lookbehind ? match[1].length : 0),
                                to = match.index + match[0].length,
                                k = i,
                                p = pos;

                            for (var len = strarr.length; k < len && (p < to || (!strarr[k].type && !strarr[k - 1].greedy)); ++k) {
                                p += strarr[k].length;
                                // Move the index i to the element in strarr that is closest to from
                                if (from >= p) {
                                    ++i;
                                    pos = p;
                                }
                            }

                            // If strarr[i] is a Token, then the match starts inside another Token, which is invalid
                            if (strarr[i] instanceof Token) {
                                continue;
                            }

                            // Number of tokens to delete and replace with the new match
                            delNum = k - i;
                            str = text.slice(pos, p);
                            match.index -= pos;
                        } else {
                            pattern.lastIndex = 0;

                            var match = pattern.exec(str),
                                delNum = 1;
                        }

                        if (!match) {
                            if (oneshot) {
                                break;
                            }

                            continue;
                        }

                        if(lookbehind) {
                            lookbehindLength = match[1] ? match[1].length : 0;
                        }

                        var from = match.index + lookbehindLength,
                            match = match[0].slice(lookbehindLength),
                            to = from + match.length,
                            before = str.slice(0, from),
                            after = str.slice(to);

                        var args = [i, delNum];

                        if (before) {
                            ++i;
                            pos += before.length;
                            args.push(before);
                        }

                        var wrapped = new Token(token, inside? _.tokenize(match, inside) : match, alias, match, greedy);

                        args.push(wrapped);

                        if (after) {
                            args.push(after);
                        }

                        Array.prototype.splice.apply(strarr, args);

                        if (delNum != 1)
                            _.matchGrammar(text, strarr, grammar, i, pos, true, token);

                        if (oneshot)
                            break;
                    }
                }
            }
        },

        tokenize: function(text, grammar, language) {
            var strarr = [text];

            var rest = grammar.rest;

            if (rest) {
                for (var token in rest) {
                    grammar[token] = rest[token];
                }

                delete grammar.rest;
            }

            _.matchGrammar(text, strarr, grammar, 0, 0, false);

            return strarr;
        },

        hooks: {
            all: {},

            add: function (name, callback) {
                var hooks = _.hooks.all;

                hooks[name] = hooks[name] || [];

                hooks[name].push(callback);
            },

            run: function (name, env) {
                var callbacks = _.hooks.all[name];

                if (!callbacks || !callbacks.length) {
                    return;
                }

                for (var i=0, callback; callback = callbacks[i++];) {
                    callback(env);
                }
            }
        }
    };

    var Token = _.Token = function(type, content, alias, matchedStr, greedy) {
        this.type = type;
        this.content = content;
        this.alias = alias;
        // Copy of the full string this token was created from
        this.length = (matchedStr || "").length|0;
        this.greedy = !!greedy;
    };

    Token.stringify = function(o, language, parent) {
        if (typeof o == 'string') {
            return o;
        }

        if (_.util.type(o) === 'Array') {
            return o.map(function(element) {
                return Token.stringify(element, language, o);
            }).join('');
        }

        var env = {
            type: o.type,
            content: Token.stringify(o.content, language, parent),
            tag: 'span',
            classes: ['token', o.type],
            attributes: {},
            language: language,
            parent: parent
        };

        if (o.alias) {
            var aliases = _.util.type(o.alias) === 'Array' ? o.alias : [o.alias];
            Array.prototype.push.apply(env.classes, aliases);
        }

        _.hooks.run('wrap', env);

        var attributes = Object.keys(env.attributes).map(function(name) {
            return name + '="' + (env.attributes[name] || '').replace(/"/g, '&quot;') + '"';
        }).join(' ');

        return '<' + env.tag + ' class="' + env.classes.join(' ') + '"' + (attributes ? ' ' + attributes : '') + '>' + env.content + '</' + env.tag + '>';

    };

    if (!_self.document) {
        if (!_self.addEventListener) {
            // in Node.js
            return _self.Prism;
        }

        if (!_.disableWorkerMessageHandler) {
            // In worker
            _self.addEventListener('message', function (evt) {
                var message = JSON.parse(evt.data),
                    lang = message.language,
                    code = message.code,
                    immediateClose = message.immediateClose;

                _self.postMessage(_.highlight(code, _.languages[lang], lang));
                if (immediateClose) {
                    _self.close();
                }
            }, false);
        }

        return _self.Prism;
    }

//Get current script and highlight
    var script = document.currentScript || [].slice.call(document.getElementsByTagName("script")).pop();

    if (script) {
        _.filename = script.src;

        if (!_.manual && !script.hasAttribute('data-manual')) {
            if(document.readyState !== "loading") {
                if (window.requestAnimationFrame) {
                    window.requestAnimationFrame(_.highlightAll);
                } else {
                    window.setTimeout(_.highlightAll, 16);
                }
            }
            else {
                document.addEventListener('DOMContentLoaded', _.highlightAll);
            }
        }
    }

    return _self.Prism;

})();

if (typeof module !== 'undefined' && module.exports) {
    module.exports = Prism;
}

// hack for components to work correctly in node.js
if (typeof global !== 'undefined') {
    global.Prism = Prism;
}


/* **********************************************
     Begin prism-markup.js
********************************************** */

Prism.languages.markup = {
    'comment': /<!--[\s\S]*?-->/,
    'prolog': /<\?[\s\S]+?\?>/,
    'doctype': /<!DOCTYPE[\s\S]+?>/i,
    'cdata': /<!\[CDATA\[[\s\S]*?]]>/i,
    'tag': {
        pattern: /<\/?(?!\d)[^\s>\/=$<%]+(?:\s+[^\s>\/=]+(?:=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+))?)*\s*\/?>/i,
        greedy: true,
        inside: {
            'tag': {
                pattern: /^<\/?[^\s>\/]+/i,
                inside: {
                    'punctuation': /^<\/?/,
                    'namespace': /^[^\s>\/:]+:/
                }
            },
            'attr-value': {
                pattern: /=(?:("|')(?:\\[\s\S]|(?!\1)[^\\])*\1|[^\s'">=]+)/i,
                inside: {
                    'punctuation': [
                        /^=/,
                        {
                            pattern: /(^|[^\\])["']/,
                            lookbehind: true
                        }
                    ]
                }
            },
            'punctuation': /\/?>/,
            'attr-name': {
                pattern: /[^\s>\/]+/,
                inside: {
                    'namespace': /^[^\s>\/:]+:/
                }
            }

        }
    },
    'entity': /&#?[\da-z]{1,8};/i
};

Prism.languages.markup['tag'].inside['attr-value'].inside['entity'] =
    Prism.languages.markup['entity'];

// Plugin to make entity title show the real entity, idea by Roman Komarov
Prism.hooks.add('wrap', function(env) {

    if (env.type === 'entity') {
        env.attributes['title'] = env.content.replace(/&amp;/, '&');
    }
});

Prism.languages.xml = Prism.languages.markup;
Prism.languages.html = Prism.languages.markup;
Prism.languages.mathml = Prism.languages.markup;
Prism.languages.svg = Prism.languages.markup;


/* **********************************************
     Begin prism-css.js
********************************************** */

Prism.languages.css = {
    'comment': /\/\*[\s\S]*?\*\//,
    'atrule': {
        pattern: /@[\w-]+?.*?(?:;|(?=\s*\{))/i,
        inside: {
            'rule': /@[\w-]+/
            // See rest below
        }
    },
    'url': /url\((?:(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1|.*?)\)/i,
    'selector': /[^{}\s][^{};]*?(?=\s*\{)/,
    'string': {
        pattern: /("|')(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
        greedy: true
    },
    'property': /[-_a-z\xA0-\uFFFF][-\w\xA0-\uFFFF]*(?=\s*:)/i,
    'important': /\B!important\b/i,
    'function': /[-a-z0-9]+(?=\()/i,
    'punctuation': /[(){};:]/
};

Prism.languages.css['atrule'].inside.rest = Prism.languages.css;

if (Prism.languages.markup) {
    Prism.languages.insertBefore('markup', 'tag', {
        'style': {
            pattern: /(<style[\s\S]*?>)[\s\S]*?(?=<\/style>)/i,
            lookbehind: true,
            inside: Prism.languages.css,
            alias: 'language-css',
            greedy: true
        }
    });

    Prism.languages.insertBefore('inside', 'attr-value', {
        'style-attr': {
            pattern: /\s*style=("|')(?:\\[\s\S]|(?!\1)[^\\])*\1/i,
            inside: {
                'attr-name': {
                    pattern: /^\s*style/i,
                    inside: Prism.languages.markup.tag.inside
                },
                'punctuation': /^\s*=\s*['"]|['"]\s*$/,
                'attr-value': {
                    pattern: /.+/i,
                    inside: Prism.languages.css
                }
            },
            alias: 'language-css'
        }
    }, Prism.languages.markup.tag);
}

/* **********************************************
     Begin prism-clike.js
********************************************** */

Prism.languages.clike = {
    'comment': [
        {
            pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/,
            lookbehind: true
        },
        {
            pattern: /(^|[^\\:])\/\/.*/,
            lookbehind: true,
            greedy: true
        }
    ],
    'string': {
        pattern: /(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
        greedy: true
    },
    'class-name': {
        pattern: /((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[\w.\\]+/i,
        lookbehind: true,
        inside: {
            punctuation: /[.\\]/
        }
    },
    'keyword': /\b(?:if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,
    'boolean': /\b(?:true|false)\b/,
    'function': /[a-z0-9_]+(?=\()/i,
    'number': /\b0x[\da-f]+\b|(?:\b\d+\.?\d*|\B\.\d+)(?:e[+-]?\d+)?/i,
    'operator': /--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/,
    'punctuation': /[{}[\];(),.:]/
};


/* **********************************************
     Begin prism-javascript.js
********************************************** */

Prism.languages.javascript = Prism.languages.extend('clike', {
    'keyword': /\b(?:as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/,
    'number': /\b(?:0[xX][\dA-Fa-f]+|0[bB][01]+|0[oO][0-7]+|NaN|Infinity)\b|(?:\b\d+\.?\d*|\B\.\d+)(?:[Ee][+-]?\d+)?/,
    // Allow for all non-ASCII characters (See http://stackoverflow.com/a/2008444)
    'function': /[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*\()/i,
    'operator': /-[-=]?|\+[+=]?|!=?=?|<<?=?|>>?>?=?|=(?:==?|>)?|&[&=]?|\|[|=]?|\*\*?=?|\/=?|~|\^=?|%=?|\?|\.{3}/
});

Prism.languages.insertBefore('javascript', 'keyword', {
    'regex': {
        pattern: /((?:^|[^$\w\xA0-\uFFFF."'\])\s])\s*)\/(\[[^\]\r\n]+]|\\.|[^/\\\[\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})\]]))/,
        lookbehind: true,
        greedy: true
    },
    // This must be declared before keyword because we use "function" inside the look-forward
    'function-variable': {
        pattern: /[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*(?=\s*=\s*(?:function\b|(?:\([^()]*\)|[_$a-z\xA0-\uFFFF][$\w\xA0-\uFFFF]*)\s*=>))/i,
        alias: 'function'
    },
    'constant': /\b[A-Z][A-Z\d_]*\b/
});

Prism.languages.insertBefore('javascript', 'string', {
    'template-string': {
        pattern: /`(?:\\[\s\S]|\${[^}]+}|[^\\`])*`/,
        greedy: true,
        inside: {
            'interpolation': {
                pattern: /\${[^}]+}/,
                inside: {
                    'interpolation-punctuation': {
                        pattern: /^\${|}$/,
                        alias: 'punctuation'
                    },
                    rest: null // See below
                }
            },
            'string': /[\s\S]+/
        }
    }
});
Prism.languages.javascript['template-string'].inside['interpolation'].inside.rest = Prism.languages.javascript;

if (Prism.languages.markup) {
    Prism.languages.insertBefore('markup', 'tag', {
        'script': {
            pattern: /(<script[\s\S]*?>)[\s\S]*?(?=<\/script>)/i,
            lookbehind: true,
            inside: Prism.languages.javascript,
            alias: 'language-javascript',
            greedy: true
        }
    });
}

Prism.languages.js = Prism.languages.javascript;


/* **********************************************
     Begin prism-file-highlight.js
********************************************** */

(function () {
    if (typeof self === 'undefined' || !self.Prism || !self.document || !document.querySelector) {
        return;
    }

    self.Prism.fileHighlight = function() {

        var Extensions = {
            'js': 'javascript',
            'py': 'python',
            'rb': 'ruby',
            'ps1': 'powershell',
            'psm1': 'powershell',
            'sh': 'bash',
            'bat': 'batch',
            'h': 'c',
            'tex': 'latex'
        };

        Array.prototype.slice.call(document.querySelectorAll('pre[data-src]')).forEach(function (pre) {
            var src = pre.getAttribute('data-src');

            var language, parent = pre;
            var lang = /\blang(?:uage)?-([\w-]+)\b/i;
            while (parent && !lang.test(parent.className)) {
                parent = parent.parentNode;
            }

            if (parent) {
                language = (pre.className.match(lang) || [, ''])[1];
            }

            if (!language) {
                var extension = (src.match(/\.(\w+)$/) || [, ''])[1];
                language = Extensions[extension] || extension;
            }

            var code = document.createElement('code');
            code.className = 'language-' + language;

            pre.textContent = '';

            code.textContent = 'Loading…';

            pre.appendChild(code);

            var xhr = new XMLHttpRequest();

            xhr.open('GET', src, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {

                    if (xhr.status < 400 && xhr.responseText) {
                        code.textContent = xhr.responseText;

                        Prism.highlightElement(code);
                    }
                    else if (xhr.status >= 400) {
                        code.textContent = '✖ Error ' + xhr.status + ' while fetching file: ' + xhr.statusText;
                    }
                    else {
                        code.textContent = '✖ Error: File does not exist or is empty';
                    }
                }
            };

            xhr.send(null);
        });

        if (Prism.plugins.toolbar) {
            Prism.plugins.toolbar.registerButton('download-file', function (env) {
                var pre = env.element.parentNode;
                if (!pre || !/pre/i.test(pre.nodeName) || !pre.hasAttribute('data-src') || !pre.hasAttribute('data-download-link')) {
                    return;
                }
                var src = pre.getAttribute('data-src');
                var a = document.createElement('a');
                a.textContent = pre.getAttribute('data-download-link-label') || 'Download';
                a.setAttribute('download', '');
                a.href = src;
                return a;
            });
        }

    };

    document.addEventListener('DOMContentLoaded', self.Prism.fileHighlight);

})();
/**
 * Original by Aaron Harun: http://aahacreative.com/2012/07/31/php-syntax-highlighting-prism/
 * Modified by Miles Johnson: http://milesj.me
 *
 * Supports the following:
 * 		- Extends clike syntax
 * 		- Support for PHP 5.3+ (namespaces, traits, generators, etc)
 * 		- Smarter constant and function matching
 *
 * Adds the following new token classes:
 * 		constant, delimiter, variable, function, package
 */
(function (Prism) {
    Prism.languages.php = Prism.languages.extend('clike', {
        'keyword': /\b(?:and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i,
        'constant': /\b[A-Z0-9_]{2,}\b/,
        'comment': {
            pattern: /(^|[^\\])(?:\/\*[\s\S]*?\*\/|\/\/.*)/,
            lookbehind: true
        }
    });

    Prism.languages.insertBefore('php', 'string', {
        'shell-comment': {
            pattern: /(^|[^\\])#.*/,
            lookbehind: true,
            alias: 'comment'
        }
    });

    Prism.languages.insertBefore('php', 'keyword', {
        'delimiter': {
            pattern: /\?>|<\?(?:php|=)?/i,
            alias: 'important'
        },
        'variable': /\$+(?:\w+\b|(?={))/i,
        'package': {
            pattern: /(\\|namespace\s+|use\s+)[\w\\]+/,
            lookbehind: true,
            inside: {
                punctuation: /\\/
            }
        }
    });

    // Must be defined after the function pattern
    Prism.languages.insertBefore('php', 'operator', {
        'property': {
            pattern: /(->)[\w]+/,
            lookbehind: true
        }
    });

    Prism.languages.insertBefore('php', 'string', {
        'nowdoc-string': {
            pattern: /<<<'([^']+)'(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\1;/,
            greedy: true,
            alias: 'string',
            inside: {
                'delimiter': {
                    pattern: /^<<<'[^']+'|[a-z_]\w*;$/i,
                    alias: 'symbol',
                    inside: {
                        'punctuation': /^<<<'?|[';]$/
                    }
                }
            }
        },
        'heredoc-string': {
            pattern: /<<<(?:"([^"]+)"(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\1;|([a-z_]\w*)(?:\r\n?|\n)(?:.*(?:\r\n?|\n))*?\2;)/i,
            greedy: true,
            alias: 'string',
            inside: {
                'delimiter': {
                    pattern: /^<<<(?:"[^"]+"|[a-z_]\w*)|[a-z_]\w*;$/i,
                    alias: 'symbol',
                    inside: {
                        'punctuation': /^<<<"?|[";]$/
                    }
                },
                'interpolation': null // See below
            }
        },
        'single-quoted-string': {
            pattern: /'(?:\\[\s\S]|[^\\'])*'/,
            greedy: true,
            alias: 'string'
        },
        'double-quoted-string': {
            pattern: /"(?:\\[\s\S]|[^\\"])*"/,
            greedy: true,
            alias: 'string',
            inside: {
                'interpolation': null // See below
            }
        }
    });
    // The different types of PHP strings "replace" the C-like standard string
    delete Prism.languages.php['string'];

    var string_interpolation = {
        pattern: /{\$(?:{(?:{[^{}]+}|[^{}]+)}|[^{}])+}|(^|[^\\{])\$+(?:\w+(?:\[.+?]|->\w+)*)/,
        lookbehind: true,
        inside: {
            rest: Prism.languages.php
        }
    };
    Prism.languages.php['heredoc-string'].inside['interpolation'] = string_interpolation;
    Prism.languages.php['double-quoted-string'].inside['interpolation'] = string_interpolation;

    Prism.hooks.add('before-tokenize', function(env) {
        if (!/(?:<\?php|<\?)/ig.test(env.code)) {
            return;
        }

        var phpPattern = /(?:<\?php|<\?)[\s\S]*?(?:\?>|$)/ig;
        Prism.languages['markup-templating'].buildPlaceholders(env, 'php', phpPattern);
    });

    Prism.hooks.add('after-tokenize', function(env) {
        Prism.languages['markup-templating'].tokenizePlaceholders(env, 'php');
    });

}(Prism));
Prism.languages['markup-templating'] = {};

Object.defineProperties(Prism.languages['markup-templating'], {
    buildPlaceholders: {
        // Tokenize all inline templating expressions matching placeholderPattern
        // If the replaceFilter function is provided, it will be called with every match.
        // If it returns false, the match will not be replaced.
        value: function (env, language, placeholderPattern, replaceFilter) {
            if (env.language !== language) {
                return;
            }

            env.tokenStack = [];

            env.code = env.code.replace(placeholderPattern, function(match) {
                if (typeof replaceFilter === 'function' && !replaceFilter(match)) {
                    return match;
                }
                var i = env.tokenStack.length;
                // Check for existing strings
                while (env.code.indexOf('___' + language.toUpperCase() + i + '___') !== -1)
                    ++i;

                // Create a sparse array
                env.tokenStack[i] = match;

                return '___' + language.toUpperCase() + i + '___';
            });

            // Switch the grammar to markup
            env.grammar = Prism.languages.markup;
        }
    },
    tokenizePlaceholders: {
        // Replace placeholders with proper tokens after tokenizing
        value: function (env, language) {
            if (env.language !== language || !env.tokenStack) {
                return;
            }

            // Switch the grammar back
            env.grammar = Prism.languages[language];

            var j = 0;
            var keys = Object.keys(env.tokenStack);
            var walkTokens = function (tokens) {
                if (j >= keys.length) {
                    return;
                }
                for (var i = 0; i < tokens.length; i++) {
                    var token = tokens[i];
                    if (typeof token === 'string' || (token.content && typeof token.content === 'string')) {
                        var k = keys[j];
                        var t = env.tokenStack[k];
                        var s = typeof token === 'string' ? token : token.content;

                        var index = s.indexOf('___' + language.toUpperCase() + k + '___');
                        if (index > -1) {
                            ++j;
                            var before = s.substring(0, index);
                            var middle = new Prism.Token(language, Prism.tokenize(t, env.grammar, language), 'language-' + language, t);
                            var after = s.substring(index + ('___' + language.toUpperCase() + k + '___').length);
                            var replacement;
                            if (before || after) {
                                replacement = [before, middle, after].filter(function (v) { return !!v; });
                                walkTokens(replacement);
                            } else {
                                replacement = middle;
                            }
                            if (typeof token === 'string') {
                                Array.prototype.splice.apply(tokens, [i, 1].concat(replacement));
                            } else {
                                token.content = replacement;
                            }

                            if (j >= keys.length) {
                                break;
                            }
                        }
                    } else if (token.content && typeof token.content !== 'string') {
                        walkTokens(token.content);
                    }
                }
            };

            walkTokens(env.tokens);
        }
    }
});
(function () {

    if (typeof self === 'undefined' || !self.Prism || !self.document) {
        return;
    }

    /**
     * Plugin name which is used as a class name for <pre> which is activating the plugin
     * @type {String}
     */
    var PLUGIN_NAME = 'line-numbers';

    /**
     * Regular expression used for determining line breaks
     * @type {RegExp}
     */
    var NEW_LINE_EXP = /\n(?!$)/g;

    /**
     * Resizes line numbers spans according to height of line of code
     * @param {Element} element <pre> element
     */
    var _resizeElement = function (element) {
        var codeStyles = getStyles(element);
        var whiteSpace = codeStyles['white-space'];

        if (whiteSpace === 'pre-wrap' || whiteSpace === 'pre-line') {
            var codeElement = element.querySelector('code');
            var lineNumbersWrapper = element.querySelector('.line-numbers-rows');
            var lineNumberSizer = element.querySelector('.line-numbers-sizer');
            var codeLines = codeElement.textContent.split(NEW_LINE_EXP);

            if (!lineNumberSizer) {
                lineNumberSizer = document.createElement('span');
                lineNumberSizer.className = 'line-numbers-sizer';

                codeElement.appendChild(lineNumberSizer);
            }

            lineNumberSizer.style.display = 'block';

            codeLines.forEach(function (line, lineNumber) {
                lineNumberSizer.textContent = line || '\n';
                var lineSize = lineNumberSizer.getBoundingClientRect().height;
                lineNumbersWrapper.children[lineNumber].style.height = lineSize + 'px';
            });

            lineNumberSizer.textContent = '';
            lineNumberSizer.style.display = 'none';
        }
    };

    /**
     * Returns style declarations for the element
     * @param {Element} element
     */
    var getStyles = function (element) {
        if (!element) {
            return null;
        }

        return window.getComputedStyle ? getComputedStyle(element) : (element.currentStyle || null);
    };

    window.addEventListener('resize', function () {
        Array.prototype.forEach.call(document.querySelectorAll('pre.' + PLUGIN_NAME), _resizeElement);
    });

    Prism.hooks.add('complete', function (env) {
        if (!env.code) {
            return;
        }

        // works only for <code> wrapped inside <pre> (not inline)
        var pre = env.element.parentNode;
        var clsReg = /\s*\bline-numbers\b\s*/;
        if (
            !pre || !/pre/i.test(pre.nodeName) ||
            // Abort only if nor the <pre> nor the <code> have the class
            (!clsReg.test(pre.className) && !clsReg.test(env.element.className))
        ) {
            return;
        }

        if (env.element.querySelector('.line-numbers-rows')) {
            // Abort if line numbers already exists
            return;
        }

        if (clsReg.test(env.element.className)) {
            // Remove the class 'line-numbers' from the <code>
            env.element.className = env.element.className.replace(clsReg, ' ');
        }
        if (!clsReg.test(pre.className)) {
            // Add the class 'line-numbers' to the <pre>
            pre.className += ' line-numbers';
        }

        var match = env.code.match(NEW_LINE_EXP);
        var linesNum = match ? match.length + 1 : 1;
        var lineNumbersWrapper;

        var lines = new Array(linesNum + 1);
        lines = lines.join('<span></span>');

        lineNumbersWrapper = document.createElement('span');
        lineNumbersWrapper.setAttribute('aria-hidden', 'true');
        lineNumbersWrapper.className = 'line-numbers-rows';
        lineNumbersWrapper.innerHTML = lines;

        if (pre.hasAttribute('data-start')) {
            pre.style.counterReset = 'linenumber ' + (parseInt(pre.getAttribute('data-start'), 10) - 1);
        }

        env.element.appendChild(lineNumbersWrapper);

        _resizeElement(pre);

        Prism.hooks.run('line-numbers', env);
    });

    Prism.hooks.add('line-numbers', function (env) {
        env.plugins = env.plugins || {};
        env.plugins.lineNumbers = true;
    });

    /**
     * Global exports
     */
    Prism.plugins.lineNumbers = {
        /**
         * Get node for provided line number
         * @param {Element} element pre element
         * @param {Number} number line number
         * @return {Element|undefined}
         */
        getLine: function (element, number) {
            if (element.tagName !== 'PRE' || !element.classList.contains(PLUGIN_NAME)) {
                return;
            }

            var lineNumberRows = element.querySelector('.line-numbers-rows');
            var lineNumberStart = parseInt(element.getAttribute('data-start'), 10) || 1;
            var lineNumberEnd = lineNumberStart + (lineNumberRows.children.length - 1);

            if (number < lineNumberStart) {
                number = lineNumberStart;
            }
            if (number > lineNumberEnd) {
                number = lineNumberEnd;
            }

            var lineIndex = number - lineNumberStart;

            return lineNumberRows.children[lineIndex];
        }
    };

}());
/*!
	autosize 4.0.2
	license: MIT
	http://www.jacklmoore.com/autosize
*/
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define(['module', 'exports'], factory);
    } else if (typeof exports !== "undefined") {
        factory(module, exports);
    } else {
        var mod = {
            exports: {}
        };
        factory(mod, mod.exports);
        global.autosize = mod.exports;
    }
})(this, function (module, exports) {
    'use strict';

    var map = typeof Map === "function" ? new Map() : function () {
        var keys = [];
        var values = [];

        return {
            has: function has(key) {
                return keys.indexOf(key) > -1;
            },
            get: function get(key) {
                return values[keys.indexOf(key)];
            },
            set: function set(key, value) {
                if (keys.indexOf(key) === -1) {
                    keys.push(key);
                    values.push(value);
                }
            },
            delete: function _delete(key) {
                var index = keys.indexOf(key);
                if (index > -1) {
                    keys.splice(index, 1);
                    values.splice(index, 1);
                }
            }
        };
    }();

    var createEvent = function createEvent(name) {
        return new Event(name, { bubbles: true });
    };
    try {
        new Event('test');
    } catch (e) {
        // IE does not support `new Event()`
        createEvent = function createEvent(name) {
            var evt = document.createEvent('Event');
            evt.initEvent(name, true, false);
            return evt;
        };
    }

    function assign(ta) {
        if (!ta || !ta.nodeName || ta.nodeName !== 'TEXTAREA' || map.has(ta)) return;

        var heightOffset = null;
        var clientWidth = null;
        var cachedHeight = null;

        function init() {
            var style = window.getComputedStyle(ta, null);

            if (style.resize === 'vertical') {
                ta.style.resize = 'none';
            } else if (style.resize === 'both') {
                ta.style.resize = 'horizontal';
            }

            if (style.boxSizing === 'content-box') {
                heightOffset = -(parseFloat(style.paddingTop) + parseFloat(style.paddingBottom));
            } else {
                heightOffset = parseFloat(style.borderTopWidth) + parseFloat(style.borderBottomWidth);
            }
            // Fix when a textarea is not on document body and heightOffset is Not a Number
            if (isNaN(heightOffset)) {
                heightOffset = 0;
            }

            update();
        }

        function changeOverflow(value) {
            {
                // Chrome/Safari-specific fix:
                // When the textarea y-overflow is hidden, Chrome/Safari do not reflow the text to account for the space
                // made available by removing the scrollbar. The following forces the necessary text reflow.
                var width = ta.style.width;
                ta.style.width = '0px';
                // Force reflow:
                /* jshint ignore:start */
                ta.offsetWidth;
                /* jshint ignore:end */
                ta.style.width = width;
            }

            ta.style.overflowY = value;
        }

        function getParentOverflows(el) {
            var arr = [];

            while (el && el.parentNode && el.parentNode instanceof Element) {
                if (el.parentNode.scrollTop) {
                    arr.push({
                        node: el.parentNode,
                        scrollTop: el.parentNode.scrollTop
                    });
                }
                el = el.parentNode;
            }

            return arr;
        }

        function resize() {
            if (ta.scrollHeight === 0) {
                // If the scrollHeight is 0, then the element probably has display:none or is detached from the DOM.
                return;
            }

            var overflows = getParentOverflows(ta);
            var docTop = document.documentElement && document.documentElement.scrollTop; // Needed for Mobile IE (ticket #240)

            ta.style.height = '';
            ta.style.height = ta.scrollHeight + heightOffset + 'px';

            // used to check if an update is actually necessary on window.resize
            clientWidth = ta.clientWidth;

            // prevents scroll-position jumping
            overflows.forEach(function (el) {
                el.node.scrollTop = el.scrollTop;
            });

            if (docTop) {
                document.documentElement.scrollTop = docTop;
            }
        }

        function update() {
            resize();

            var styleHeight = Math.round(parseFloat(ta.style.height));
            var computed = window.getComputedStyle(ta, null);

            // Using offsetHeight as a replacement for computed.height in IE, because IE does not account use of border-box
            var actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(computed.height)) : ta.offsetHeight;

            // The actual height not matching the style height (set via the resize method) indicates that
            // the max-height has been exceeded, in which case the overflow should be allowed.
            if (actualHeight < styleHeight) {
                if (computed.overflowY === 'hidden') {
                    changeOverflow('scroll');
                    resize();
                    actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(window.getComputedStyle(ta, null).height)) : ta.offsetHeight;
                }
            } else {
                // Normally keep overflow set to hidden, to avoid flash of scrollbar as the textarea expands.
                if (computed.overflowY !== 'hidden') {
                    changeOverflow('hidden');
                    resize();
                    actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(window.getComputedStyle(ta, null).height)) : ta.offsetHeight;
                }
            }

            if (cachedHeight !== actualHeight) {
                cachedHeight = actualHeight;
                var evt = createEvent('autosize:resized');
                try {
                    ta.dispatchEvent(evt);
                } catch (err) {
                    // Firefox will throw an error on dispatchEvent for a detached element
                    // https://bugzilla.mozilla.org/show_bug.cgi?id=889376
                }
            }
        }

        var pageResize = function pageResize() {
            if (ta.clientWidth !== clientWidth) {
                update();
            }
        };

        var destroy = function (style) {
            window.removeEventListener('resize', pageResize, false);
            ta.removeEventListener('input', update, false);
            ta.removeEventListener('keyup', update, false);
            ta.removeEventListener('autosize:destroy', destroy, false);
            ta.removeEventListener('autosize:update', update, false);

            Object.keys(style).forEach(function (key) {
                ta.style[key] = style[key];
            });

            map.delete(ta);
        }.bind(ta, {
            height: ta.style.height,
            resize: ta.style.resize,
            overflowY: ta.style.overflowY,
            overflowX: ta.style.overflowX,
            wordWrap: ta.style.wordWrap
        });

        ta.addEventListener('autosize:destroy', destroy, false);

        // IE9 does not fire onpropertychange or oninput for deletions,
        // so binding to onkeyup to catch most of those events.
        // There is no way that I know of to detect something like 'cut' in IE9.
        if ('onpropertychange' in ta && 'oninput' in ta) {
            ta.addEventListener('keyup', update, false);
        }

        window.addEventListener('resize', pageResize, false);
        ta.addEventListener('input', update, false);
        ta.addEventListener('autosize:update', update, false);
        ta.style.overflowX = 'hidden';
        ta.style.wordWrap = 'break-word';

        map.set(ta, {
            destroy: destroy,
            update: update
        });

        init();
    }

    function destroy(ta) {
        var methods = map.get(ta);
        if (methods) {
            methods.destroy();
        }
    }

    function update(ta) {
        var methods = map.get(ta);
        if (methods) {
            methods.update();
        }
    }

    var autosize = null;

    // Do nothing in Node.js environment and IE8 (or lower)
    if (typeof window === 'undefined' || typeof window.getComputedStyle !== 'function') {
        autosize = function autosize(el) {
            return el;
        };
        autosize.destroy = function (el) {
            return el;
        };
        autosize.update = function (el) {
            return el;
        };
    } else {
        autosize = function autosize(el, options) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], function (x) {
                    return assign(x, options);
                });
            }
            return el;
        };
        autosize.destroy = function (el) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], destroy);
            }
            return el;
        };
        autosize.update = function (el) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], update);
            }
            return el;
        };
    }

    exports.default = autosize;
    module.exports = exports['default'];
});











/*
*  Altair Admin
*  author: tzd
*
*  1. Init functions
*  2. Helpers / Variables
*  3. Common functions & variables
*
* */

// 1. Init common functions on document ready

$(function() {
    "use strict";

    // forms
    altair_forms.init();


});


// 2. Helpers

/* Detect hi-res devices */
function isHighDensity() {
    return ((window.matchMedia && (window.matchMedia('only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)').matches)) || (window.devicePixelRatio && window.devicePixelRatio > 1.3));
}

/* Calculate Scrollbar Width (http://chris-spittles.co.uk/jquery-calculate-scrollbar-width/) */
function scrollbarWidth(){var a=jQuery('<div style="width: 100%; height:200px;">test</div>'),b=jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append(a),c=a[0],a=b[0];jQuery("body").append(a);c=c.offsetWidth;b.css("overflow","scroll");a=a.clientWidth;b.remove();return c-a};

/* random id generator */
function randID_generator() {
    var randLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));
    return randLetter + Date.now();
}

/* detect IE */
function detectIE(){var a=window.navigator.userAgent,b=a.indexOf("MSIE ");if(0<b)return parseInt(a.substring(b+5,a.indexOf(".",b)),10);if(0<a.indexOf("Trident/"))return b=a.indexOf("rv:"),parseInt(a.substring(b+3,a.indexOf(".",b)),10);b=a.indexOf("Edge/");return 0<b?parseInt(a.substring(b+5,a.indexOf(".",b)),10):!1};

/* reverse array */
jQuery.fn.reverse = [].reverse;

/* serialize form */
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

/* hex 2 rgba conversion */
function hex2rgba(hex,opacity){
    hex = hex.replace('#','');
    r = parseInt(hex.substring(0,2), 16);
    g = parseInt(hex.substring(2,4), 16);
    b = parseInt(hex.substring(4,6), 16);

    result = 'rgba('+r+','+g+','+b+','+opacity/100+')';
    return result;
}

/* Modernizr test for localStorage */
function lsTest(){
    var test = 'test';
    try {
        localStorage.setItem(test, test);
        localStorage.removeItem(test);
        return true;
    } catch(e) {
        return false;
    }
}

// selectize plugin
if(typeof $.fn.selectize != 'undefined') {

    // inline dropdown
    Selectize.define('dropdown_after', function(options) {
        this.positionDropdown = (function () {
            var $control = this.$control,
                position = $control.position(),
                position_left = position.left,
                position_top = position.top + $control.outerHeight(true) + 32;

            this.$dropdown.css({
                width : $control.outerWidth(),
                top   : position_top,
                left  : position_left
            });

        });
    });

    // tooltip
    Selectize.define('tooltip', function(options) {
        var self = this;
        this.setup = (function() {
            var original = self.setup;
            return function() {
                original.apply(this, arguments);
                var $wrapper = this.$wrapper,
                    $input = this.$input;
                if($input.attr('title')) {
                    $wrapper
                        .attr('title', $input.attr('title'))
                        .attr('data-uk-tooltip', $input.attr('data-uk-tooltip'));
                }
            };
        })();
    });

    Selectize.define('drag_drop', function(options) {
        if (!$.fn.sortable) throw new Error('The "drag_drop" plugin requires jQuery UI "sortable".');
        if (this.settings.mode !== 'multi') return;
        var self = this;

        self.lock = (function() {
            var original = self.lock;
            return function() {
                var sortable = self.$control.data('sortable');
                if (sortable) sortable.disable();
                return original.apply(self, arguments);
            };
        })();

        self.unlock = (function() {
            var original = self.unlock;
            return function() {
                var sortable = self.$control.data('sortable');
                if (sortable) sortable.enable();
                return original.apply(self, arguments);
            };
        })();

        self.setup = (function() {
            var original = self.setup;
            return function() {
                original.apply(this, arguments);

                var $control = self.$control.sortable({
                    items: '[data-value]',
                    forcePlaceholderSize: true,
                    disabled: self.isLocked,
                    start: function(e, ui) {
                        ui.placeholder.css('width', ui.helper.css('width'));
                        $control.css({overflow: 'visible'});
                    },
                    stop: function() {
                        $control.css({overflow: 'hidden'});
                        var active = self.$activeItems ? self.$activeItems.slice() : null;
                        var values = [];
                        $control.children('[data-value]').each(function() {
                            values.push($(this).attr('data-value'));
                        });
                        self.setValue(values);
                        self.setActiveItem(active);
                    },
                    helper: function(event, ui){
                        var $clone =  $(ui).clone();
                        $clone .css('position','absolute');
                        return $clone.get(0);
                    }
                });
            };
        })();

    });

    Selectize.define('remove_button', function(options) {
        options = $.extend({
            label     : '&times;',
            title     : 'Remove',
            className : 'remove',
            append    : true
        }, options);

        var escape_html = function(str) {
            return (str + '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        };

        var singleClose = function(thisRef, options) {

            options.className = options.className || 'remove-single';

            var self = thisRef;
            var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';

            /**
             * Appends an element as a child (with raw HTML).
             *
             * @param {string} html_container
             * @param {string} html_element
             * @return {string}
             */
            var append = function(html_container, html_element) {
                var pos = html_container.search(/(<\/[^>]+>\s*)$/);
                return html_container.substring(0, pos) + html_element + html_container.substring(pos);
            };

            thisRef.setup = (function() {
                var original = self.setup;
                return function() {
                    // override the item rendering method to add the button to each
                    if (options.append) {
                        var id = $(self.$input.context).attr('id');
                        var selectizer = $('#'+id);

                        var render_item = self.settings.render.item;
                        self.settings.render.item = function(data) {
                            return append(render_item.apply(thisRef, arguments), html);
                        };
                    }

                    original.apply(thisRef, arguments);

                    // add event listener
                    thisRef.$control.on('click', '.' + options.className, function(e) {
                        e.preventDefault();
                        if (self.isLocked) return;

                        self.clear();
                    });

                };
            })();
        };

        var multiClose = function(thisRef, options) {

            var self = thisRef;
            var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';

            /**
             * Appends an element as a child (with raw HTML).
             *
             * @param {string} html_container
             * @param {string} html_element
             * @return {string}
             */
            var append = function(html_container, html_element) {
                var pos = html_container.search(/(<\/[^>]+>\s*)$/);
                return html_container.substring(0, pos) + html_element + html_container.substring(pos);
            };

            thisRef.setup = (function() {
                var original = self.setup;
                return function() {
                    // override the item rendering method to add the button to each
                    if (options.append) {
                        var render_item = self.settings.render.item;
                        self.settings.render.item = function(data) {
                            return append(render_item.apply(thisRef, arguments), html);
                        };
                    }

                    original.apply(thisRef, arguments);

                    // add event listener
                    thisRef.$control.on('click', '.' + options.className, function(e) {
                        e.preventDefault();
                        if (self.isLocked) return;

                        var $item = $(e.currentTarget).parent();
                        self.setActiveItem($item);
                        if (self.deleteSelection()) {
                            self.setCaret(self.items.length);
                        }
                    });

                };
            })();
        };

        if (this.settings.mode === 'single') {
            singleClose(this, options);
            return;
        } else {
            multiClose(this, options);
        }
    });
}


// 3. Common functions & variables

// 3.1 material design easing
// 3.2 page onload init functions
// 3.3 page content
// 3.4 forms
// 3.5 main sidebar / main menu (left)
// 3.6 secondary sidebar (right)
// 3.7 top bar
// 3.8 main header
// 3.9 material design
// 3.10 common helpers
// 3.11 uikit custom


// 3.1 material design easing
easing_swiftOut = [ 0.35,0,0.25,1 ];
bez_easing_swiftOut = $.bez(easing_swiftOut);

var $body = $('body'),
    $html = $('html'),
    $document = $(document),
    $window = $(window),
    $page_content = $('#page_content'),
    $page_content_inner = $('#page_content_inner'),
    $sidebar_main = $('#sidebar_main'),
    $sidebar_main_toggle = $('#sidebar_main_toggle'),
    $sidebar_secondary = $('#sidebar_secondary'),
    $sidebar_secondary_toggle = $('#sidebar_secondary_toggle'),
    $topBar = $('#top_bar'),
    $pageHeading = $('#page_heading'),
    $pageAside = $('#page_aside'),
    $pageOverflow = $('#page_overflow'),
    $header_main = $('#header_main'),
    header__main_height = 48;



// 3.3 page content
altair_page_content = {
    hide_content_sidebar: function() {
        if(!$body.hasClass('header_double_height')) {
            //$page_content.css('max-height',$html.height() - 40);
            $html.css({
                'paddingRight': scrollbarWidth(),
                'overflow': 'hidden'
            });
        }
    },
    show_content_sidebar: function() {
        if(!$body.hasClass('header_double_height')) {
            //$page_content.css('max-height','');
            $html.css({
                'paddingRight': '',
                'overflow': ''
            });
        }
    }
};

// 3.4 forms
altair_forms = {
    init: function() {
        altair_forms.textarea_autosize();
        altair_forms.select_elements();
        altair_forms.select_elements_2();
        altair_forms.switches();
        altair_forms.dynamic_fields();
    },
    textarea_autosize: function() {
        $textarea = $('textarea.md-input').not('.no_autosize');
        if($textarea.hasClass('autosized')) {
            autosize.destroy($textarea);
        }
        autosize($textarea);
        $textarea.addClass('autosized');
    },
    select_elements: function(parent) {

        var $selectize = parent ? $(parent).find("[data-md-selectize-delayed]") : $("[data-md-selectize],.data-md-selectize");

        $selectize.each(function(){
            var $this = $(this);
            if(!$this.hasClass('selectized')) {
                var thisPosBottom = $this.attr('data-md-selectize-bottom'),
                    sel_plugins = ['tooltip'];

                $this
                    .after('<div class="selectize_fix"></div>')
                    .selectize({
                        plugins: sel_plugins,
                        hideSelected: true,
                        dropdownParent: 'body',
                        onDropdownOpen: function($dropdown) {
                            $dropdown
                                .hide()
                                .velocity('slideDown', {
                                    begin: function() {
                                        if (typeof thisPosBottom !== 'undefined') {
                                            $dropdown.css({'margin-top':'0'})
                                        }
                                    },
                                    duration: 200,
                                    easing: easing_swiftOut
                                })
                        },
                        onDropdownClose: function($dropdown) {
                            $dropdown
                                .show()
                                .velocity('slideUp', {
                                    complete: function() {
                                        if (typeof thisPosBottom !== 'undefined') {
                                            $dropdown.css({'margin-top': ''})
                                        }
                                    },
                                    duration: 200,
                                    easing: easing_swiftOut
                                });
                        },
                        onChange: function(value) {
                            if( !!$this.attr('data-parsley-id')) {
                                $this.parsley().validate();
                            }
                        },
                        onInitialize: function() {
                            if($this[0].selectize.isRequired) {
                                $this.prop('required', true);
                            }
                        }
                    });
            }
        });

        // dropdowns
        var $selectize_inline = parent ? $(parent).find("[data-md-selectize-inline-delayed]") : $("[data-md-selectize-inline]");

        $selectize_inline.each(function(){
            var $this = $(this);
            if(!$this.hasClass('selectized')) {
                var thisPosBottom = $this.attr('data-md-selectize-bottom');
                $this
                    .after('<div class="selectize_fix"></div>')
                    .closest('div').addClass('uk-position-relative')
                    .end()
                    .selectize({
                        plugins: [
                            'dropdown_after'
                        ],
                        dropdownParent: $this.closest('div'),
                        hideSelected: true,
                        onDropdownOpen: function($dropdown) {
                            $dropdown
                                .hide()
                                .velocity('slideDown', {
                                    begin: function() {
                                        if (typeof thisPosBottom !== 'undefined') {
                                            $dropdown.css({'margin-top':'0'})
                                        }
                                    },
                                    duration: 200,
                                    easing: easing_swiftOut
                                })
                        },
                        onDropdownClose: function($dropdown) {
                            $dropdown
                                .show()
                                .velocity('slideUp', {
                                    complete: function() {
                                        if (typeof thisPosBottom !== 'undefined') {
                                            $dropdown.css({'margin-top': ''})
                                        }
                                    },
                                    duration: 200,
                                    easing: easing_swiftOut
                                });
                        },
                        onChange: function(value) {
                            if( !!$this.attr('data-parsley-id')) {
                                $this.parsley().validate();
                            }
                        }
                    });
            }
        })

    },
    select_elements_2: function(parent) {
        var $select2 = parent ? $(parent).find("[data-md-select2-delayed]") : $("[data-md-select2],.md-select2");

        $select2.each(function() {
            var $this = $(this);
            if (!$this.hasClass('select2-hidden-accessible')) {
                $this.select2({
                    closeOnSelect: false
                })
            }

            $this.on('select2:open', function (e) {
                var $dropdown = $('.select2-dropdown');
                $dropdown.hide();
                setTimeout(function() {
                    $dropdown.velocity('slideDown', {
                        duration: 150,
                        easing: easing_swiftOut
                    })
                },50)
            });

        })
    },
    // switchery plugin
    switches: function(parent) {
        var $elem = parent ? $(parent).find('[data-switchery]') : $('[data-switchery]');
        if($elem.length) {
            $elem.each(function() {
                if(!$(this).siblings('.switchery').length) {
                    var $this = this,
                        this_size = $($this).attr('data-switchery-size'),
                        this_color = $($this).attr('data-switchery-color'),
                        this_secondary_color = $($this).attr('data-switchery-secondary-color');

                    var switchery = new Switchery($this, {
                        color: (typeof this_color !== 'undefined') ? hex2rgba(this_color,50) : hex2rgba('#009688',50),
                        jackColor: (typeof this_color !== 'undefined') ? hex2rgba(this_color,100) : hex2rgba('#009688',100),
                        secondaryColor: (typeof this_secondary_color !== 'undefined') ? hex2rgba(this_secondary_color,50) : 'rgba(0, 0, 0,0.26)',
                        jackSecondaryColor: (typeof this_secondary_color !== 'undefined') ? hex2rgba(this_secondary_color,50) : '#fafafa',
                        className: 'switchery' + ( (typeof this_size !== 'undefined') ? ' switchery-'+ this_size : '' )
                    });

                    $(this).data('ObjSwitchery', switchery);

                }
            })
        }
    },
    parsley_validation_config: function() {
        window.ParsleyConfig = {
            excluded: 'input[type=button], input[type=submit], input[type=reset], input[type=hidden], input.exclude_validation',
            trigger: 'change',
            errorsWrapper: '<div class="parsley-errors-list"></div>',
            errorTemplate: '<span></span>',
            errorClass: 'md-input-danger',
            successClass: 'md-input-success',
            errorsContainer: function (ParsleyField) {
                var element = ParsleyField.$element;
                return element.closest('.parsley-row');
            },
            classHandler: function (ParsleyField) {
                var element = ParsleyField.$element;
                if( element.is(':checkbox') || element.is(':radio') || element.parent().is('label') || $(element).is('[data-md-selectize]') ) {
                    return element.closest('.parsley-row');
                }
            }
        };
    },
    parsley_extra_validators: function() {
        window.ParsleyConfig = window.ParsleyConfig || {};
        window.ParsleyConfig.validators = window.ParsleyConfig.validators || {};

        window.ParsleyConfig.validators.date = {
            fn: function (value) {

                var matches = /^(\d{2})[.\/](\d{2})[.\/](\d{4})$/.exec(value);
                if (matches == null) return false;

                var parts = value.split(/[.\/-]+/),
                    day = parseInt(parts[1], 10),
                    month = parseInt(parts[0], 10),
                    year = parseInt(parts[2], 10);

                if (year == 0 || month == 0 || month > 12) {
                    return false;
                }
                var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)) {
                    monthLength[1] = 29;
                }
                return day > 0 && day <= monthLength[month - 1];
            },
            priority: 256
        };
    },
    dynamic_fields: function(parent,resize,fields_on_load) {
        function add_fields(wrapper,template,index) {

            var source   = $("#"+template).html(),
                tmpl = Handlebars.compile(source),
                theCompiledHtml = tmpl({
                    index: index ? index : 0,
                    counter:  index ? '__' + index : '__' + 0
                });

            wrapper.append(theCompiledHtml);

            // initialize inputs
            altair_md.inputs(wrapper);
            // initialize checkboxes
            altair_md.checkbox_radio(wrapper.find('[data-md-icheck]'));
            // initialize switches
            altair_forms.switches(wrapper);
            // initialize selectize
            altair_forms.select_elements(wrapper);

        }
        var $dynamic_fields = parent ? $(parent).find('[data-dynamic-fields]') : $('[data-dynamic-fields]');
        $dynamic_fields.each(function () {
            var $this = $(this).attr('dynamic-fields-counter',0),
                this_template = $this.data('dynamicFields');

            if(!fields_on_load) {
                add_fields($this,this_template);
            }

            $this
                // add section
                .on('click','.btnSectionClone',function (e) {
                    e.preventDefault();
                    $this.find('.btnSectionClone').replaceWith('<a href="#" class="btnSectionRemove"><i class="material-icons md-24">&#xE872;</i></a>');

                    var index = parseInt($this.attr('dynamic-fields-counter')) + 1;
                    $this.attr('dynamic-fields-counter',index);

                    add_fields($this,this_template,index);

                    if(resize) {
                        $window.resize();
                    }
                })
                // remove section
                .on('click', '.btnSectionRemove', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    $this.closest('.form_section').next('.form_hr').remove().end().remove();
                    if(resize) {
                        $window.resize();
                    }
                });

        });
    }
};

