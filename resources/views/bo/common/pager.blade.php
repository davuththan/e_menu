<div class="box-footer clearfix">
     <uib-pagination 
	     total-items="totalItems" 
	     items-per-page = "itemPerpage"
	     ng-change = "pageChanged()"
	     ng-model="currentPage" 
	     ng-show = "visible"
	     max-size="maxSize" 
	     class="pagination-sm pagination no-margin pull-right" 
	     boundary-links="true" >
	     <!-- num-pages="numPages" -->
     </uib-pagination>
</div>