define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, uiRegistry, select) {
    'use strict';

    return select.extend({
        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
            var that = this,
                imageField = uiRegistry.get(that.parentName + '.image'),
                videoField = uiRegistry.get(that.parentName + '.video');

            if (imageField.visibleValue == value) {
                imageField.show();
            } else {
                imageField.hide();
            }

            if (videoField.visibleValue == value) {
                videoField.show();
            } else {
                videoField.hide();
            }

            return this._super();
        }
    });
});