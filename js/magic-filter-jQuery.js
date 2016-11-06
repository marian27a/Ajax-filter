;(function ($) {

    var defaults = {
        separator: ', ',
    }

    function MagicFilter(options, elements){
        this.config = $.extend({},defaults,options);
        this.elements = elements;
        this.init();
    }

    MagicFilter.prototype.init = function () {
        var self = this;

        this._categoryArray = [];
        for( var i = 0; i < this.elements.length; i++){
            this._categoryArray.push($(this.elements[i]).attr('data-target'));

        }
        this._categoryArray = this._categoryArray.filter(this.unicArrayFilter);

        this.createCategoryObj();
        //{
        //    #condition: [],
        //    #price: [],
        //}
        this.action(self);

    }

    MagicFilter.prototype.unicArrayFilter = function (value, index, arr) {
        return arr.indexOf(value) === index;
    }

    MagicFilter.prototype.createCategoryObj = function(){
        this._objCategory = {};
        for( var i = 0; i < this._categoryArray.length; i++){
            this._objCategory[this._categoryArray[i]] = [];
        }
        return this._objCategory;
    }

    MagicFilter.prototype.action = function(self){
        //1. отслидить клик
        //2. взять data-target
        //3. собрать все выбранные чекбоксы
        //4. вывести значение в блок
        $(this.elements).on('click', function () {
            var categoryObj = self.createCategoryObj();
            var target = $(this).attr('data-target');
            var checkbox = '[data-target=' + target + ']'+':checked';
            $(checkbox).each(function () {
                categoryObj[target].push(this.value);
            })
            //var checkbox = `[data-target=${target}]`;

            $(target).text(categoryObj[target].join(self.config.separator));
            self.sendAjax(categoryObj);
        })
    }

    MagicFilter.prototype.sendAjax = function(obj){
        $('.loader').fadeIn('slow');
        $.ajax({
            type: 'get',
            url: 'item.html',
            data: JSON.stringify(obj),
            success: function(response){
                $('.loader').fadeOut('slow');
                $('.content-load').append(response);
            }
        })
    }

    $.fn.magicFilter = function(options){
        new MagicFilter(options, this);
    }
})(jQuery)