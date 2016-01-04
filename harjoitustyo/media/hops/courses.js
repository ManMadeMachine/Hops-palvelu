$(document).ready(function(){
    $("#lisaaButton_syksy").on('click', function(){
            
        var tiedot = $("#syksy").val().split(",");

        $("#kurssit_syksy").append(
            '<tr class="kurssirivi">'+
                '<input type="hidden" name="ktunnus_syksy[]" value="' + tiedot[0] + '"/>' +
                '<td class="opintojakso_tunnus">'+ tiedot[0] +'</td>'+
                '<td class="opintojakso_nimi">'+ tiedot[1] +'</td>'+
                '<td class="opintopisteet">'+ tiedot[2] +'</td>'+
                '<td class="oppiaine">'+ tiedot[3] +'</td>'+
                '<td class="poista_kurssirivi"><input type="button" class="poista_rivi_button" value="Poista" /></td>'+
            '</tr>'
        );
             
        $("#syksy").val("");
                                
        $(".poista_rivi_button").each(function(){
            var $elem = $(this);
                    
            if ( $elem.data('click-init')) {
                return true;   
            }
                    
            $elem.data('click-init', true);
                    
            $elem.on('click', function() {
                $elem.parents("tr").remove();
            });

        });
             
    });
});
        
$(document).ready(function()
{
    $("#lisaaButton_kevat").on('click', function()
    {
        var tiedot = $("#kevat").val().split(",");
                
        $("#kurssit_kevat").append(
            '<tr class="kurssirivi">'+
                '<input type="hidden" name="ktunnus_kevat[]" value="' + tiedot[0] + '"/>' +
                '<td class="opintojakso_tunnus">'+ tiedot[0] +'</td>'+
                '<td class="opintojakso_nimi">'+ tiedot[1] +'</td>'+
                '<td class="opintopisteet">'+ tiedot[2] +'</td>'+
                '<td class="oppiaine">'+ tiedot[3] +'</td>'+
                '<td class="poista_kurssirivi"><input type="button" class="poista_rivi_button" value="Poista" /></td>'+
            '</tr>'
        );
                
        $("#kevat").val("");            
                
        $(".poista_rivi_button").each(function(){
            var $elem = $(this);
                    
            if ( $elem.data('click-init')) {
                return true;   
            }
                    
            $elem.data('click-init', true);
                    
            $elem.on('click', function() {
                $elem.parents("tr").remove();
            });

        });
    });
});  

$(document).ready(function()
{
    $("#work_no").on('change', function() 
    {
        if (document.getElementById('work_no').checked) {
            document.getElementById('work_type').value = '';
            document.getElementById('work_type').disabled = true;
            document.getElementById('work_amount').value = '';
            document.getElementById('work_amount').disabled = true;
            document.getElementById('reason').disabled = false;

        }
    });
    $("#work_yes").on('change', function() 
    {
        if ( document.getElementById('work_yes').checked) {
            document.getElementById('work_type').disabled = false;
            document.getElementById('work_amount').disabled = false;
            document.getElementById('reason').value = '';
            document.getElementById('reason').disabled = true;
        }

    });

    
});


