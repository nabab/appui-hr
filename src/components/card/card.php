<bbn-tabnav :scrollable="false"
            :autoload="false"
>
  <bbns-container v-if="source.tabs.home"
                  url="home"
                  icon="nf nf-mdi-account_card_details"
                  :notext="true"
                  :load="false"
                  :source="source"
                  :component="isObject(source.tabs.home) && source.tabs.home.component ? source.tabs.home.component : 'appui-hr-card-tab-home'"
                  :static="true"
                  title="<?=_('Home')?>"
  ></bbns-container>
  <bbns-container v-if="source.tabs.jobs"
                  url="jobs"
                  icon="nf nf-mdi-worker"
                  :notext="true"
                  :load="false"
                  :source="source"
                  :component="isObject(source.tabs.jobs) && source.tabs.jobs.component ? source.tabs.jobs.component : 'appui-hr-card-tab-jobs'"
                  :static="true"
                  title="<?=_('List of working days')?>"
  ></bbns-container>
</bbn-tabnav>