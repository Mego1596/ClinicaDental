function selectDetalle(idReceta,idDetalle,medicamento,dosis,cantidad){
    $('#modalEditDetalle #medicamento_edit').val(medicamento);
    $('#modalEditDetalle #dosis_edit').val(dosis);
    $('#modalEditDetalle #cantidad_edit').val(cantidad);
    $('#modalEditDetalle #formularioEdicion').attr('action','/recetas/'+idReceta+"/detalles/"+idDetalle);
}