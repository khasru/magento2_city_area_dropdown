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
            if (typeof value != 'undefined') {
                if (registry.get(this.parentName + '.' + 'country_id')) {
                    var country_id = registry.get(this.parentName + '.' + 'country_id').uid;
                    jQuery('#' + country_id).val("").change();
                    jQuery('#' + country_id).val("BD").change();
                }
                // region.update("BD");
                var region_ids=[];
                jQuery(".customer_form_areas_address_address_customer_address_update_modal._show [name='region_id'] option").each(function (){
                    var val =jQuery(this).val();
                    if(jQuery.inArray(val, region_ids)==-1) {
                        region_ids.push(val);
                    } else {
                        jQuery(this).hide();
                    }
                });
            }
        }
    });
});