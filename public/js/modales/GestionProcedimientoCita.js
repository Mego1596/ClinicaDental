function addProcedimiento(procedimientos,nuevo = 0){
	//NUEVO SIRVE PARA RECONOCER QUE FORMULARIO ES EN AMBOS METODOS
	let form = ""
	if(nuevo == 1){
		 form = '#form_antiguo '
	}else{
        if(nuevo == 2){
            form = '#form_editar '
        }else{
            if(nuevo == 3){
                form = '#form_seguimiento '
            }else{
                form = '#form_nuevo '
            }
        }
	}
	let numero_select = $(form+'#procedimientos_create div.form-group.row').length+1
	let html_code = ""
			+"<div class='form-group row' id='procedimiento_select_antiguo_"+numero_select+"'>" 
        		+"<div class='col-sm-3'>"
        			+"<select class='form-control' id='select_"+numero_select+"' name='procedimiento["+numero_select+"][id]' required>"
        			+"<option value='' selected>Seleccione el procedimiento</option>"
    if ($(form+'#procedimientos_create').is(':empty')) {
        $.each(procedimientos,function(i,value)
        {
        	html_code = 
        			html_code+"<option id='procedimiento_"+value['id']+"' value='"+value['id']+"'>"+value['nombre']+"</option>"
        });
        html_code=html_code
        			+"</select>"
        		+"</div>"
                +"<div class='col-sm-4'>"
                    +"<input id='input_1_"+numero_select+"' type='number' step='1' min='1' max='32' name='procedimiento["+numero_select+"][numero_piezas]' class='form-control' placeholder='Numero de piezas' required />"
                +"</div>"
                +"<div class='col-sm-4'>"
                    +"<input id='input_2_"+numero_select+"' type='number' step='0.01' min='0.01' name='procedimiento["+numero_select+"][honorarios]' class='form-control' placeholder='Honorarios' required />"
                +"</div>"
        		+"<div class='col-sm-1' id='remove_div_"+numero_select+"'>"
        			+"<i class=' btn far fa-times-circle' style='color:red' onclick='removeProcedimiento("+numero_select+","+nuevo+")' id='remove_"+numero_select+"'></i>"
        		+"</div>"
        	+"</div>"

        $(form+'#procedimientos_create').html(html_code)
		 
    }else{
        if($('#select_'+(numero_select-1)).val() != "" && $('#input_1_'+(numero_select-1)).val() != "" && $('#input_2_'+(numero_select-1)).val() != ""){
            procedimientos_seleccionados = [];
            for(i=1; i <= numero_select; i++){
                if( i < numero_select){
                    $(form+'#select_'+i).attr('disabled',true).attr('readonly',true)
                    $(form+'#input_1_'+i).attr('disabled',true).attr('readonly',true)
                    $(form+'#input_2_'+i).attr('disabled',true).attr('readonly',true)
                    $(form+'#remove_'+i).remove();
                }
                procedimientos_seleccionados.push(parseInt($(form+'#select_'+i).val()))
            }
            $.each(procedimientos,function(i,value)
            {   
                if(!procedimientos_seleccionados.includes(value['id'])){
                    html_code = 
                        html_code+"<option id='procedimiento_"+value['id']+"' value='"+value['id']+"'>"+value['nombre']+"</option>"
                }
            });
            html_code=html_code
                        +"</select>"
                    +"</div>"
                    +"<div class='col-sm-4'>"
                        +"<input id='input_1_"+numero_select+"' type='number' step='1' min='1' max='32' name='procedimiento["+numero_select+"][numero_piezas]' class='form-control' placeholder='Numero de piezas' required />"
                    +"</div>"
                    +"<div class='col-sm-4'>"
                        +"<input id='input_2_"+numero_select+"' type='number' step='0.01' min='0.01' name='procedimiento["+numero_select+"][honorarios]' class='form-control' placeholder='Honorarios' required />"
                    +"</div>"
                    +"<div class='col-sm-1' id='remove_div_"+numero_select+"'>"
                        +"<i class=' btn far fa-times-circle' style='color:red' onclick='removeProcedimiento("+numero_select+","+nuevo+")' id='remove_"+numero_select+"'></i>"
                    +"</div>"
                +"</div>"
            $(form+'#procedimientos_create').append(html_code)
        }else{
            
        }
    	
    }
}

function removeProcedimiento(select_tag, nuevo){
	let form = ""
    if(nuevo == 1){
         form = '#form_antiguo '
    }else{
        if(nuevo == 2){
            form = '#form_editar '
        }else{
            if(nuevo == 3){
                form = '#form_seguimiento '
            }else{
                form = '#form_nuevo '
            }
        }
    }
	let numero_select = $(form+'#procedimientos_create div.form-group.row').length+1
	if(numero_select == 1){
		$(form+'#procedimientos_create').empty();
	}else{
		$(form+'#remove_div_'+(select_tag-1)).html(
			"<i class=' btn far fa-times-circle' style='color:red' onclick='removeProcedimiento("+(select_tag-1)+","+nuevo+")' id='remove_"+(select_tag-1)+"'></i>"
		)
		$(form+'#select_'+(select_tag-1)).attr('disabled',false).attr('readonly',false)
        $(form+'#input_1_'+(select_tag-1)).attr('disabled',false).attr('readonly',false)
        $(form+'#input_2_'+(select_tag-1)).attr('disabled',false).attr('readonly',false)
		$(form+'#procedimiento_select_antiguo_'+select_tag).remove();
	}
}    

function enviarForm(form){
	$(form).submit(function(){
    	let numero_select = $(form+'#procedimientos_create div.form-group.row').length+1
		for(i=1; i <= numero_select; i++){
    		if( i < numero_select){
    			$(form+'#select_'+i).attr('disabled',false)
                $(form+'#input_1_'+i).attr('disabled',false)
                    $(form+'#input_2_'+i).attr('disabled',false)
    		}
    	}
	});
}        
						    
						      