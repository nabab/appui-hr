<div class="bbn-full-screen appui-hr-card-tab-info">
  <bbn-dashboard storage-full-name="appui-hr-card-dashboard"
                 ref="dashboard"
                 :sortable="true"
                 :order="source.widgets_order"
  >
    <bbns-widget v-if="source.widgets.info"
                 :title="source.widgets.info.text"
                 :component="source.widgets.info.component"
                 :source="source"
                 :buttonsRight="infoBtns"
                 :closable="source.widgets.info.closable"
                 :icon="source.widgets.info.icon"
                 :uid="source.widgets.info.key"
                 :hidden="source.widgets.info.hidden"
                 :index="source.widgets.info.num"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.week"
                 :title="source.widgets.week.text"
                 :component="source.widgets.week.component"
                 :source="source"
                 :closable="false"
                 :icon="source.widgets.week.icon"
                 :uid="source.widgets.week.key"
                 :hidden="source.widgets.week.hidden"
                 :index="source.widgets.week.num"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.summary"
                 :title="source.widgets.summary.text + ' ' + currentYear"
                 :component="source.widgets.summary.component"
                 :source="source"
                 :closable="source.widgets.summary.closable"
                 :icon="source.widgets.summary.icon"
                 :uid="source.widgets.summary.key"
                 :hidden="source.widgets.summary.hidden"
                 :index="source.widgets.summary.num"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.summary_chart"
                 :title="source.widgets.summary_chart.text + ' ' + currentYear"
                 component="appui-hr-card-widget-summary-chart"
                 :source="source"
                 :closable="source.widgets.summary.closable"
                 :icon="source.widgets.summary.icon"
                 uid="source.widgets.summary_chart.key"
                 :hidden="source.widgets.summary.hidden"
                 :index="source.widgets.summary_chart.num"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.upcoming"
                 :title="source.widgets.upcoming.text"
                 :component="source.widgets.upcoming.component"
                 :source="source"
                 :closable="source.widgets.upcoming.closable"
                 :icon="source.widgets.upcoming.icon"
                 :uid="source.widgets.upcoming.key"
                 :hidden="source.widgets.upcoming.hidden"
                 :index="source.widgets.upcoming.num"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.entities && source.entities && source.entities.length"
                 :title="source.widgets.entities.text"
                 :component="source.widgets.entities.component"
                 :source="source"
                 :closable="source.widgets.entities.closable"
                 :icon="source.widgets.entities.icon"
                 :uid="source.widgets.entities.key"
                 :hidden="source.widgets.entities.hidden"
                 :index="source.widgets.entities.num"
    ></bbns-widget>
  </bbn-dashboard>
</div>