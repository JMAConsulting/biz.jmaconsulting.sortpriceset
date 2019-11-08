{literal}
<script type="text/javascript">
CRM.$(function($) {
  $('table th:nth-child(3)').after('<th>Weights</th>');

  var weights = $.parseJSON('{/literal}{$weights}{literal}');
  $('table tr').each(function(e) {
    if (e > 0) {
      $('td:nth-child(3)', this).after('<td>' + weights[$('td:nth-child(1)', this).text()] + '</td>');
    }
  });

});
</script>
{/literal}
