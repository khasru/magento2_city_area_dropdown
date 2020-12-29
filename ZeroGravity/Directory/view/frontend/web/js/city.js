/*global define*/

define([
    'jquery',
    'Magento_Ui/js/form/element/select',
    'ko',
    'Magento_Ui/js/form/element/region',
    'uiRegistry',
], function($,Component,ko,region,registry) {
    'use strict';
    return Component.extend({
        initialize: function () {
            this._super();
            this.update(this.defaults);
            return this;
        },
        defaults: {
            imports: {
                update: '${ $.parentName }.city:value'
            },
            //options: []
        },
        value: 'Dhaka',

        update: function (value) {
          //  console.log(value);
            if(registry.get(this.parentName + '.' + 'country_id')) {
                var country_id = registry.get(this.parentName + '.' + 'country_id').uid;
                jQuery('#' + country_id).val("").change();
                jQuery('#' + country_id).val("BD").change();
            }
        }
    });
});