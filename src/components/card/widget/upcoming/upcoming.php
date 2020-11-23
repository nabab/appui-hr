<div class="appui-hr-card-widget-upcoming bbn-rel">
  <bbn-table :source="source.upcoming"
             :pageable="false"
						 :scrollable="false"
             :show-limit="false"
             :show-total-items="false"
  >
    <bbns-column title="<?=_('Du')?>"
                 field="start"
                 cls="bbn-c"
								 type="date"
    ></bbns-column>
    <bbns-column title="<?=_('Au')?>"
                 field="end"
                 cls="bbn-c"
								 type="date"
    ></bbns-column>
    <bbns-column title="<?=_('Type')?>"
                 field="id_type"
                 :source="absences"
                 cls="bbn-c"
    ></bbns-column>
  </bbn-table>
</div>