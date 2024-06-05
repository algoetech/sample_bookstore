
        $(document).ready(function() {
            $('#toggleButton').click(function() {

                let e = $(this).data('model');
                
                $('#add').toggleClass('hidden');
                $('#list').toggleClass('hidden');
                $('#buttonText').text(function(i, text){
                    return text === `List ${e}` ? `Add ${e}` : `List ${e}`;
                });
            });





        });
