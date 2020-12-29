define([
    'uiRegistry',
], function(registry){
    'use strict';

    return function(RegionCity){
        //if targetModule is a uiClass based object
        return RegionCity.extend({

            filter: function (value, field)
            {
                var result = this._super(); //call parent method

                var country = registry.get(this.parentName + '.' + 'country_id'),
                    _city = registry.get(this.parentName + '.' + 'city'),
                    option;
                var countryId=country.uid;


                if(_city){
                    var cityid=_city.uid;
                    var cityValue="";
                    if(cityid){
                        cityValue=jQuery('#'+cityid).val();
                    }

                    if (typeof cityValue != 'undefined'){
                        this._super(cityValue, 'city');
                    }else{
                        jQuery('#'+cityid).val(_city.initialValue);
                        this._super(_city.initialValue, 'city');
                    }
                }
                return result;
            }
        });
    };
});