define([
    'jquery'
], function ($) {
    'use strict';
    var mixin = {
        defaults: {
            template: 'ScripCo_UiGridAdmin/grid/search/search'
        },
        configKeyword: function () {
            if(typeof this.additionalInfo!='undefined' && this.additionalInfo)
            {
                return this.additionalInfo;
            }
            return false;
        }
    };
    return function (target) {
        return target.extend(mixin);
    };
});

