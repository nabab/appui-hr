<div class="appui-hr-card-widget-week">
  <div class="bbn-spadding appui-hr-card-widget-week-types bbn-bottom-sspace">
    <div v-for="absence in card.absences" class="bbn-vmiddle">
      <div class="bbn-hsmargin appui-hr-card-widget-week-types-square bbn-border"
            :style="{backgroundColor: absence.color}"
      ></div>
      <span v-text="absence.text"></span>
    </div>
  </div>
  <div class="bbn-flex appui-hr-card-widget-week-days">
    <div v-for="day in days"
        class="bbn-flex appui-hr-card-widget-week-block"
    >
      <div v-text="day.initials"></div>
      <div v-text="day.day"
          :class="[
            'appui-hr-card-widget-week-day',
            'bbn-unselectable',
            'bbn-middle',
            'bbn-spadding',
            'bbn-top-sspace',
            {
              'bbn-background': !day.today,
              'bbn-primary': day.today
            }
          ]"
          :style="{'border-bottom': day.color ? '7px solid ' + day.color : false}"
      ></div>
    </div>
  </div>
</div>