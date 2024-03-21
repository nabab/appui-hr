<div class="ami-hr-card-widget-summary">
  <div class="bbn-middle bbn-box bbn-no-radius"
       v-for="(tot, id) in source.summary"
  >
    <div class="bbn-c">
      <div v-text="getText(id)"></div>
      <div class="days" :style="{color: getColor(id)}">
        <strong v-text="tot"></strong>
      </div>
      <div v-text="tot === 1 ? '<?= _('day')?>' : '<?=_('days') ?>'"></div>
    </div>
  </div>
</div>