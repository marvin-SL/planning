var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

$('#app_mailing_mails').selectize({
    persist: false,
    maxItems: null,
    valueField: 'email',
    labelField: 'email',
    searchField: ['email'],
    delimiter: ';',
    maxItems: 50,
    render: {
        item: function(item, escape) {
            return '<div>'+
                (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
            '</div>';
        },
        option: function(item, escape) {
            var label = item.email;
            return '<div>' +
                '<span class="label">' + escape(label) + '</span>' +
            '</div>';
        }
    },
    create: function(input) {
        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
            return {email: input};
        }
        alert('Invalid email address.');
        return false;
    }
});


$('#cc').selectize({
    persist: false,
    maxItems: null,
    valueField: 'email',
    labelField: 'email',
    searchField: ['email'],
    delimiter: ';',
    maxItems: 50,
    render: {
        item: function(item, escape) {
            return '<div>'+
                (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
            '</div>';
        },
        option: function(item, escape) {
            var label = item.email;
            return '<div>' +
                '<span class="label">' + escape(label) + '</span>' +
            '</div>';
        }
    },
    create: function(input) {
        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
            return {email: input};
        }
        alert('Invalid email address.');
        return false;
    }
});
