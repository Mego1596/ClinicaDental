function selectProcedimiento(id,nombre,descripcion,editar = 1){
    $('#modalEditProcedimiento #nombre_edit').val(nombre);
    $('#modalEditProcedimiento #descripcion_edit').val(descripcion);
    $('#modalEditProcedimiento #formularioEdicion').attr('action','procedimientos/'+id);
    let botones = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>'
        botones +='<button type="submit" class="btn btn-success">Guardar</button>'
    if(!editar){
    	$('#nombre_edit').attr('readonly',true).attr('disabled',true)
    	$('#descripcion_edit').attr('readonly',true).attr('disabled',true)
    }else{
    	$('#nombre_edit').attr('readonly',false).attr('disabled',false)
    	$('#descripcion_edit').attr('readonly',false).attr('disabled',false)
        $('#modalEditProcedimiento .modal-footer').html(botones);
    }
}

