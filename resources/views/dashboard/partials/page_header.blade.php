<div class="col-md-12">
    <div class="page-header{{ PAGE_HEADER_CUSTOM ? '-custom' : '' }}">
        <h1>
            {{ @$page_title }}

            @if (@$page_sub_title)
                <i class="ace-icon fa fa-angle-double-right"></i> {{ @$page_sub_title }}
            @endif

            @if (@$page_sub_sub_title)
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i> {{ @$page_sub_sub_title }}
                </small>
            @endif

            @if (@$new_record)
                <a href="{{ @$route }}" class="dynamic-modal btn btn-primary btn-sm pull-right btn-action new-entry"
                    data-modal-target="{{ @$modal }}" title="{{ @$btnTitle ?? @$btnText }}">
                    <i class="fa fa-plus"></i> {{ @$btnText }}
                </a>
            @endif
        </h1>
    </div>

</div>
