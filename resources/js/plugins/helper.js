export default {
    validateEmail(value) {
        var patt = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
        return patt.test(value);
    },

    date_time(value) {
        return moment(value).format("YYYY年MM月DD日 HH:mm")
    },

    date(value) {
        return moment(value).format("YYYY年MM月DD日")
    },

    date_month_day(value) {
        return moment(value).format("MM/DD")
    },
    date_en(value) {
        return moment(value).format("YYYY-MM-DD")
    },

    removeArrayWithValue(arr) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax= arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    },

    validChecks(formData, excepts) {
        return Object.keys(formData).filter(item => !excepts.includes(item))
                .filter(key => (!formData[key] || formData[key] === '' || formData[key] === 0));
    }
}