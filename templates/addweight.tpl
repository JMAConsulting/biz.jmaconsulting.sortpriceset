<table>
  <tr id="weight-block">
    <td class="label">
      {$form.weight.label}
    </td>
    <td>
      {$form.weight.html}
    </td>
  </tr>
</table>

{literal}
<script type="text/javascript">
 CRM.$(function($) {
   console.log($('#weight-block'));
   $('#weight-block').insertAfter('#min_amount');
 });
</script>
{/literal}
