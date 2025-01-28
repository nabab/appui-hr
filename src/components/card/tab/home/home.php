<div class="bbn-full-screen appui-hr-card-tab-info">
  <bbn-dashboard storage-full-name="appui-hr-card-dashboard"
                 ref="dashboard"
                 :sortable="true"
                 :order="source.widgets_order"
  >
    <bbns-widget v-if="source.widgets.info"
                 :label="source.widgets.info.text"
                 :component="source.widgets.info.component"
                 :source="source"
                 :buttonsRight="infoBtns"
                 :closable="source.widgets.info.closable"
                 :icon="source.widgets.info.icon"
                 :uid="source.widgets.info.key"
                 :invisible="source.widgets.info.hidden"
                 :index="source.widgets.info.num"
                 :padding="true"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.week"
                 :label="source.widgets.week.text"
                 :component="source.widgets.week.component"
                 :source="source"
                 :closable="false"
                 :icon="source.widgets.week.icon"
                 :uid="source.widgets.week.key"
                 :invisible="source.widgets.week.hidden"
                 :index="source.widgets.week.num"
                 :padding="true"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.summary"
                 :label="source.widgets.summary.text + ' ' + currentYear"
                 :component="source.widgets.summary.component"
                 :source="source"
                 :closable="source.widgets.summary.closable"
                 :icon="source.widgets.summary.icon"
                 :uid="source.widgets.summary.key"
                 :invisible="source.widgets.summary.hidden"
                 :index="source.widgets.summary.num"
                 :padding="true"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.summary_chart"
                 :label="source.widgets.summary_chart.text + ' ' + currentYear"
                 component="appui-hr-card-widget-summary-chart"
                 :source="source"
                 :closable="source.widgets.summary.closable"
                 :icon="source.widgets.summary.icon"
                 uid="source.widgets.summary_chart.key"
                 :invisible="source.widgets.summary.hidden"
                 :index="source.widgets.summary_chart.num"
                 :padding="true"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.upcoming"
                 :label="source.widgets.upcoming.text"
                 :component="source.widgets.upcoming.component"
                 :source="source"
                 :closable="source.widgets.upcoming.closable"
                 :icon="source.widgets.upcoming.icon"
                 :uid="source.widgets.upcoming.key"
                 :invisible="source.widgets.upcoming.hidden"
                 :index="source.widgets.upcoming.num"
                 :padding="true"
    ></bbns-widget>
    <bbns-widget v-if="source.widgets.entities && source.entities && source.entities.length"
                 :label="source.widgets.entities.text"
                 :component="source.widgets.entities.component"
                 :source="source"
                 :closable="source.widgets.entities.closable"
                 :icon="source.widgets.entities.icon"
                 :uid="source.widgets.entities.key"
                 :invisible="source.widgets.entities.hidden"
                 :index="source.widgets.entities.num"
                 :padding="true"
    ></bbns-widget>
  </bbn-dashboard>
</div>