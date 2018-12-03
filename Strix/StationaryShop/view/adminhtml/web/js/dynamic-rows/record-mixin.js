define(function () {
    'use strict';

    var mixin = {
        /**
         * Child visibility listener
         *
         * @param {Object} data
         */
        childVisibleListener: function (data) {
            var dataType = this.data().type,
                dataIndex = data.index;

            if (dataType === '2' && dataIndex === 'video' || dataType === '1' && dataIndex === 'image') {
                data.visible(true);
            }
            this.setVisibilityColumn(dataIndex, data.visible());
        }
    };

    return function (record) {
        return record.extend(mixin);
    };
});