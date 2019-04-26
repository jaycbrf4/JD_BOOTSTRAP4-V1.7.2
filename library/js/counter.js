
//script to count the characters typed into the SEO Title MetaBox in Backend
 (function($) {

    $(document).ready(function() {

            var titleElement = $('#seo_title');

            if(titleElement.exists())
            {
                var title_max       = 55;
                var title_length    = titleElement.val().length;

                $('.seo_title_count').html(title_length + ' characters of ' + title_max);

                titleElement.keyup(function() 
                {
                    var title_length2 = titleElement.val().length;
                    var title_remaining = title_max - title_length2;

                    $('.seo_title_count').html(title_length2 + ' characters of ' + title_max);
                });
            }    


        var descriptionElement = $('#seo_description');

        if(descriptionElement.exists())
        {
            //script to count the characters typed into the Description MetaBox in Backend
            var description_max     = 155;
            var description_length  = descriptionElement.val().length;

            $('.seo_description_count').html(description_length + ' characters of  ' + description_max);

            descriptionElement.keyup(function() 
            {
                var description_length2 = descriptionElement.val().length;
                var description_remaining = description_max - description_length2;

                $('.seo_description_count').html(description_length2 + ' characters of ' + description_max);
            });
        }


    }); // End Doc Ready

})(jQuery); // Closing Function

(function($){
    $.fn.exists = function () {
        return this.length !== 0;
    }
})(jQuery);
