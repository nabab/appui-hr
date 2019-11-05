<bbn-tabnav :scrollable="false"
            :autoload="false"
>
  <bbns-container url="home"
                  icon="nf nf-mdi-account_card_details"
                  :notext="true"
                  :load="false"
                  :source="source"
                  component="appui-hr-card-tab-home"
                  :static="true"
                  title="<?=_('Home')?>"
  ></bbns-container>
  <bbns-container url="jobs"
                  icon="nf nf-mdi-worker"
                  :notext="true"
                  :load="false"
                  :source="source"
                  component="appui-hr-card-tab-jobs"
                  :static="true"
                  title="<?=_('List of working days')?>"
  ></bbns-container>
</bbn-tabnav>