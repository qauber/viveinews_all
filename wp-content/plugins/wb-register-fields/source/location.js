
function transliterate(word){
    var answer = ""
      , a = {};

   a["Ё"]="YO";a["Й"]="I";a["Ц"]="TS";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="SH";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="'";
   a["ё"]="yo";a["й"]="i";a["ц"]="ts";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="sh";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="'";
   a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="a";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="ZH";a["Э"]="E";
   a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="zh";a["э"]="e";
   a["Я"]="Ya";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="'";a["Б"]="B";a["Ю"]="YU";
   a["я"]="ya";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="'";a["б"]="b";a["ю"]="yu";

   for (i in word){
     if (word.hasOwnProperty(i)) {
       if (a[word[i]] === undefined){
         answer += word[i];
       } else {
         answer += a[word[i]];
       }
     }
   }
   return answer;
}

    function ajaxCall() {
        this.send = function(data, url, method, success, type) {
          type = type||'json';
          var successRes = function(data) {
              success(data);
          }

          var errorRes = function(e) {
              console.log(e);
              alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
          }
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: successRes,
                error: errorRes,
                dataType: type,
                timeout: 60000
            });

          }

        }

function locationInfo() {
    var rootUrl = "http://lab.iamrohit.in/php_ajax_country_state_city_dropdown/api.php";
    var call = new ajaxCall();
    
    
    this.getCities = function(country_id,region_id) {
        $("#cityId option:gt(0)").remove();
        $('#show-city').hide();
        $('#cityId').hide();
        
        
        /*
        var url = rootUrl+'?type=getCities&stateId=' + id;
        var method = "post";
        var data = {};
        $('#cityId').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            if(data.tp == 1){
                $('#cityId').find("option:eq(0)").html("Select City");
                $("#cityId").prop("disabled",false);
                $.each(data['result'], function(key, val) {
                	var val = val.replace("'","");
                	var val = val.replace("s'","s");
                	var val = val.replace("yyi","yi");
                    var option = $('<option />');
                    option.attr('value', key+':'+val).text(val);
                    $('#show-city').show();
                    $('#cityId').append(option).show();
                });
                if(data['result'].length == 0)
                    $("#cityId").attr('disabled', true);
            } else {
                 alert(data.msg);
            }
        });
        */
        var url = '/get_countries.php?action=get_cities&country_id=' + country_id + '&region_id=' + region_id;
        var method = "post";
        var data = {};
        $('#cityId').find("option:eq(0)").html("Please wait..");
        $('#cityId').show();
        $('#show-city').show();
        call.send(data, url, method, function(data) {
            if(data.response.count){
                $('#cityId').find("option:eq(0)").html("Select City");
                $("#cityId").prop("disabled",false);
                $.each(data.response.items, function(key, val) {
                	
                	//val.title = transliterate(val.title);
                	
                    var option = $('<option />');
                    option.attr('value', val.id+':'+val.title).text(val.title);
                    
                    $('#cityId').append(option).show();
                });

            } else {
            	//$("#cityId").attr('disabled', true);
                //alert(data.msg);
                $('#cityId').find("option:eq(0)").html("Select City");                
                var countryId = $('#countryId').val();
        		countryId = countryId.split(':');
                var id = countryId[0];
                var title = countryId[1];
                var option = $('<option />');
                option.attr('value', id+':'+title).text(title);
                $('#show-city').show();
                $('#cityId').append(option).show();  
                
            }
        });        
    };



    this.getStates = function(id) {
        $("#stateId option:gt(0)").remove(); 
        $("#cityId option:gt(0)").remove(); 
        $('#show-state').hide();
        $('#show-city').hide();
   

        
        /*
        var url = rootUrl+'?type=getStates&countryId=' + id;
        var method = "post";
        var data = {};
        $('#stateId').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            if(data.tp == 1){
                $('#stateId').find("option:eq(0)").html("Select state");
                $.each(data['result'], function(key, val) {
                    if(val == "Petrik" || val == "Byram") return;
                    var val = val.replace("'","");
                    var val = val.replace("s'","s");
                    var val = val.replace("yyi","yi");
                    var option = $('<option />');
                    option.attr('value', key+':'+val).text(val);
                    $('#show-state').show();
                    $('#stateId').append(option).show();
                });
                $("#stateId").prop("disabled",false);
            } else {
                alert(data.msg);
            }
        }); 
        */

        var url = '/get_countries.php?action=get_regions&country_id=' + id;
        var method = "post";
        var data = {};
        
        $('#stateId').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            if(data.response.count){
                $('#stateId').find("option:eq(0)").html("Select state");
                $.each(data.response.items, function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val.id+':'+val.title).text(val.title);
                    $('#show-state').show();
                    $('#stateId').append(option).show();
                });
                $("#stateId").prop("disabled",false);
            } else {
                //alert('error');
                
                $('#stateId').find("option:eq(0)").html("Select state");                
                var countryId = $('#countryId').val();
        		countryId = countryId.split(':');
                var id = countryId[0];
                var title = countryId[1];
                var option = $('<option />');
                option.attr('value', id+':'+title).text(title);
                $('#show-state').show();
                $('#stateId').append(option).show();                
            }
        }); 
        
    };

    this.getCountries = function() {
    	/*
        var url = rootUrl+'?type=getCountries';
        var method = "post";
        var data = {};
        $('.info-errors').remove();
        $('#countryId').find("option:eq(0)");
        call.send(data, url, method, function(data) {
            $('#countryId').find("option:eq(0)");
            if(data.tp == 1){
                $.each(data['result'], function(key, val) {
                	var val = val.replace("'","");
                	var val = val.replace("s'","s");
                	var val = val.replace("yyi","yi");
                    var option = $('<option />');
                    option.attr('value', key+':'+val).text(val);
                    $('#countryId').append(option);
                });
                $("#countryId").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        }); 
        */
        
        var url = '/get_countries.php?action=get_countries';
        var method = "post";
        var data = {};
        $('.info-errors').remove();
        $('#countryId').find("option:eq(0)");
        call.send(data, url, method, function(data) {
            $('#countryId').find("option:eq(0)");
            
            
            if(data.response.count){
                $.each(data.response.items, function(key, val) {
                    var option = $('<option />');
                    option.attr('value', val.id+':'+val.title).text(val.title);
                    $('#countryId').append(option);
                    
                });
                $("#countryId").prop("disabled",false);
            }
            else{
                alert('error');
            }
        });         
                
    };

}

function get_countries() {
var loc = new locationInfo();
loc.getCountries();
}

function get_states() {
        var countryId = $('#countryId').val();
        countryId = countryId.split(':');
        if(countryId[0] != ''){
            var loc = new locationInfo();
            loc.getStates(countryId[0]);
        } else {
            $("#stateId option:gt(0)").remove();
            $("#cityId option:gt(0)").remove();
            $('#show-state').hide();
            $('#show-city').hide();
        }
}

function get_cities() {
	
	
        var countryId = $('#countryId').val();
        countryId = countryId.split(':');
	
        var stateId = $('#stateId').val();
        stateId = stateId.split(':');
        
        if((stateId[0] != '') && (countryId[0] != '')){
        	var loc = new locationInfo();
        	loc.getCities(countryId[0],stateId[0]);
        }
        else{
            $("#cityId option:gt(0)").remove();
            $('#show-city').hide();
  }
}