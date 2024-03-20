crud.field('mode').onChange(function(field) {
    crud.field('transaction_code').show(field.value == 'gcash');
  }).change();