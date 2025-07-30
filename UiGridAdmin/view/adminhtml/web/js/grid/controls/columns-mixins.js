define([
    'jquery'
], function ($) {
    'use strict';
    var mixin = {
        addColumns: function (columns) {
            var sortingArray  = [];
            var columnData  = [];
            columns = _.where(columns, {
                controlVisibility: true
            });
            columns.forEach(function(value) {
                if(typeof value.label!='undefined' && value.label)
                {
                    sortingArray.push(value.label);
                    columnData[value.label] = value;
                }
                
            });
            sortingArray.sort();
            var sortedColumns = [];
            sortingArray.forEach(function(value) {
                if(columnData[value])
                {
                    sortedColumns.push(columnData[value]);
                }
            });
            this.insertChild(sortedColumns);
            return this;
        }
    };
    return function (target) {
        return target.extend(mixin);
    };
});

