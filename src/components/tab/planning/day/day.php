<div class="bbn-right-xsspace bbn-bottom-xsspace bbn-left-xsspace">
  <bbn-scroll>
    <bbn-initial v-for="(em, i) in employes" 
                 :user-name="em"
                 :key="i"
                 class="bbn-xsmargin"
                 :width="20"
    ></bbn-initial>
</bbn-scroll>
</div>
