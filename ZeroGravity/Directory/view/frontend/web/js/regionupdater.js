
define([
    'jquery'
], function ($) {

    return function (widget) {
        $.widget('zerogravity.regioncityupdater', widget, {
            /**
             * {@inheritDoc}
             */
            _initCountryElement: function () {

                if (this.options.isMultipleCountriesAllowed) {
                    this.element.parents('div.field').show();
                    this.element.on('change', $.proxy(function (e) {
                        this._updateRegion($(e.target).val());
                    }, this));
                    $('#city').on('change', $.proxy(function (e) {
                        this._updateRegion(this.element.val());
                    }, this));

                    if (this.options.isCountryRequired) {
                        this.element.addClass('required-entry');
                        this.element.parents('div.field').addClass('required');
                    }
                } else {
                    this.element.parents('div.field').hide();
                }
            },

            /**
             * Update dropdown list based on the country selected
             *
             * @param {String} country - 2 uppercase letter for country code
             * @private
             */
            _updateRegion: function (country) {
                // Clear validation error messages
                var regionList = $(this.options.regionListId),
                    regionInput = $(this.options.regionInputId),
                    postcode = $(this.options.postcodeId),
                    label = regionList.parent().siblings('label'),
                    requiredLabel = regionList.parents('div.field');

                var selectedCity = $('#city').val();



                this._clearError();
                this._checkRegionRequired(country);
                // Populate state/province dropdown list if available or use input box
                if (this.options.regionJson[country]) {
                    this._removeSelectOptions(regionList);
                    if(selectedCity) {
                        $.each(this.options.regionJson[country], $.proxy(function (key, value) {
                            if(value.city==selectedCity) {
                                this._renderSelectOption(regionList, key, value);
                            }
                        }, this));
                    }else{
                        $.each(this.options.regionJson[country], $.proxy(function (key, value) {
                            this._renderSelectOption(regionList, key, value);
                        }, this));
                    }

                    if (this.currentRegionOption) {
                        regionList.val(this.currentRegionOption);
                    }

                    if (this.setOption) {
                        regionList.find('option').filter(function () {
                            return this.text === regionInput.val();
                        }).attr('selected', true);
                    }

                    if (this.options.isRegionRequired) {
                        regionList.addClass('required-entry').removeAttr('disabled');
                        requiredLabel.addClass('required');
                    } else {
                        regionList.removeClass('required-entry validate-select').removeAttr('data-validate');
                        requiredLabel.removeClass('required');

                        if (!this.options.optionalRegionAllowed) { //eslint-disable-line max-depth
                            regionList.attr('disabled', 'disabled');
                        }
                    }

                    regionList.show();
                    regionInput.hide();
                    label.attr('for', regionList.attr('id'));
                } else {
                    this._removeSelectOptions(regionList);

                    if (this.options.isRegionRequired) {
                        regionInput.addClass('required-entry').removeAttr('disabled');
                        requiredLabel.addClass('required');
                    } else {
                        if (!this.options.optionalRegionAllowed) { //eslint-disable-line max-depth
                            regionInput.attr('disabled', 'disabled');
                        }
                        requiredLabel.removeClass('required');
                        regionInput.removeClass('required-entry');
                    }

                    regionList.removeClass('required-entry').prop('disabled', 'disabled').hide();
                    regionInput.show();
                    label.attr('for', regionInput.attr('id'));
                }

                // If country is in optionalzip list, make postcode input not required
                if (this.options.isZipRequired) {
                    $.inArray(country, this.options.countriesWithOptionalZip) >= 0 ?
                        postcode.removeClass('required-entry').closest('.field').removeClass('required') :
                        postcode.addClass('required-entry').closest('.field').addClass('required');
                }

                // Add defaultvalue attribute to state/province select element
                regionList.attr('defaultvalue', this.options.defaultRegion);
            }
        });
        return $.zerogravity.regioncityupdater;
    };
});