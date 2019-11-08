<div id="crm-price-set-form-block-weight">
    <span class="label">
      {$form.weight.label}
    </span>
    <span>
      {$form.weight.html}
    </span>
  </div>

{literal}
<script type="text/javascript">
 CRM.$(function($) {
   $('#crm-price-set-form-block-weight').insertAfter('#min_amount');
 });
</script>
{/literal}
