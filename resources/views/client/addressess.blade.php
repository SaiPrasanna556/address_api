<!DOCTYPE html>
<html lang="en">
    <head>
    <title>User Addresses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=your_key"></script>
    
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">  
                    <div class="col-sm-3"></div>  
                    <div class="col-sm-6 address_div">
                        <form id="AddressForm" method="post">
                        <h3>User Addresses</h3>
                        <div class="">                   
                            @CSRF() 
                            <input type="radio" name="address_type0" value="1" checked/>
                            <label>Home</label>&nbsp;&nbsp;
                            <input type="radio" name="address_type0" value="2"/>
                            <label>Work</label>
                            <br/><br/>
                            <input required  id="address_autocomplete0" type="text" class="form-control" name="address[]" placeholder="address">
                            <br/>
                            <br/>
                            <div class="dynamic_address_view1"></div>
                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="AddAddress()">Add one more Address</button>
                            <br/><br/>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            
                        </div>
                        </form>
                    </div>        
                    <div class="col-sm-3"></div>          
                </div>
            </div>        
        </div>
    </body>
    <script>
        var autocomplete;
        function initialize(value) {
            
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('address_autocomplete'+ value)),
                { types: ['geocode'] });
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
            });
        }
        initialize(0);
        var i = 1;
        function AddAddress(){
            
            var htmlElements =  '<input type="radio" name="address_type'+i+'" value="1" checked/>';
                htmlElements += '<label>Home</label>&nbsp;&nbsp;';
                htmlElements += '<input type="radio" name="address_type'+i+'" value="2"/>';
                htmlElements += '<label>Work</label>';
                htmlElements += '<br/><br/>';
                htmlElements += '<input required id="address_autocomplete'+i+'" type="text" class="form-control " name="address[]" placeholder="address">';
                htmlElements += '<br/>';
                htmlElements += '<br/>';
                var j = i+1; 
                htmlElements += '<div class="dynamic_address_view'+j+'"></div>';
                
            $(".dynamic_address_view" + i).html(htmlElements);
            initialize(i);
            i++;
            
        }
        
    </script>
    <script>
        $(document).on("submit","form#AddressForm",function(){
            $.ajax({
                type:'post',
                headers: {
                    'token':'{{$api_token}}',
                },
                url:'/api/user/saveAddress',
                dataType:'json',
                data:$(this).serialize(),
                success:function(data){
                    
                    $(".address_div").html('</br><h3>'+ data.msg + '</h3>');
                },
                error:function(data){
                    debugger;
                    $(".address_div").html('</br><h3>'+ data.responseJSON.msg + '</h3>');

                }
                
            });
            return false;
        });
    </script>
</html>
