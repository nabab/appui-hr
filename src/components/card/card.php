<bbn-router :scrollable="false"
            :autoload="false"
            :nav="true"
>
  <bbns-container v-if="source.tabs.home"
                  url="home"
                  icon="nf nf-md-account_card_details"
                  :notext="true"
                  :load="false"
                  :source="source"
                  :component="isObject(source.tabs.home) && source.tabs.home.component ? source.tabs.home.component : 'appui-hr-card-tab-home'"
                  :fixed="true"
                  label="<?= _('Home') ?>"
  ></bbns-container>
  <bbns-container v-if="source.tabs.jobs"
                  url="jobs"
                  icon="nf nf-md-worker"
                  :notext="true"
                  :load="false"
                  :source="source"
                  :component="isObject(source.tabs.jobs) && source.tabs.jobs.component ? source.tabs.jobs.component : 'appui-hr-card-tab-jobs'"
                  :fixed="true"
                  label="<?= _('List of working days') ?>"
  ></bbns-container>
  <bbns-container v-if="source.tabs.holidays"
                  url="holidays"
                  icon="nf nf-md-beach"
                  :notext="true"
                  :load="false"
                  :source="source"
                  :component="isObject(source.tabs.holidays) && source.tabs.holidays.component ? source.tabs.holidays.component : 'appui-hr-card-tab-holidays'"
                  :fixed="true"
                  label="<?= _('Holidays') ?>"
                  bcolor="skyblue"
                  fcolor="white"
  ></bbns-container>
</bbn-router>