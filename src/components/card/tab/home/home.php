<div class="bbn-full-screen appui-hr-card-tab-info">
  <bbn-dashboard storage-full-name="appui-hr-card-dashboard"
                 ref="dashboard"
                 :sortable="false"
  >
    <bbns-widget title="<i class='nf nf-fa-info'></i> <?=_("Information")?>"
                 component="appui-hr-card-widget-info"
                 :source="source"
                 :buttonsRight="infoBtns"              
                 :closable="false"
    ></bbns-widget>
    <bbns-widget title="<i class='nf nf-mdi-calendar_range'></i> <?=_("Week")?>"
                 component="appui-hr-card-widget-week"
                 :source="source" 
                 :closable="false"             
    ></bbns-widget>
    <bbns-widget :title="'<i class=\'nf nf-fa-calendar_o\'></i> <?=_("Summary")?> ' + currentYear"
                 component="appui-hr-card-widget-summary"
                 :source="source" 
                 :closable="false"             
    ></bbns-widget>
    <bbns-widget title="<i class='nf nf-fa-calendar_o'></i> <?=_("Imminent absences")?>"
                 component="appui-hr-card-widget-upcoming"
                 :source="source" 
                 :closable="false"             
    ></bbns-widget>
    <bbns-widget v-if="source.entities && source.entities.length"
                 title="<i class='nf nf-fa-building'></i> <?=_("Assigned work sites")?>"
                 component="appui-hr-card-widget-entities"
                 :source="source" 
                 :closable="false"
    ></bbns-widget>
  </bbn-dashboard>
</div>