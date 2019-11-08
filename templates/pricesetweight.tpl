{literal}
<script type="text/javascript">
CRM.$(function($) {
  $('table th:nth-child(3)').after('<th>Weights</th>');

  var weights = $.parseJSON('{/literal}{$weights}{literal}');
  console.log(weights);
  $('table tr').each(function(e) {
    if (e > 0) {
      console.log(e);
      $('td:nth-child(3)', this).after('<td>' + weights[e] + '</td>');
    }
  });

});
</script>
{/literal}
