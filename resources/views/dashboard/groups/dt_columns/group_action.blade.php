<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a href="#" title="Group: {{ @$record->group_number }}" class="clarify_tertiary-">
            <i class="fa fa-folder-open"></i>
            <span> View Details </span>
        </a>

        <a class="dynamic-modal" data-modal-target="modal-large" title="Edit:  Group - {{ @$record->group_number }}"
            href="{{ route('module.create', ['Module' => 'groups', 'Model' => ModelHelper::TableFromView(class_basename(@$record)), 'ModelId' => GeneralHelper::encrypt_data(@$record->id), 'Section' => 'group']) }}">
            <i class="fa fa-edit"></i> Edit Record
        </a>

        @if (!@$record->in_use)
            <a href="javascript:;" class="delete-row danger"
                data-model="{{ ModelHelper::TableFromView(class_basename(@$record)) }}"
                data-model-id="{{ @$record->id }}" data-reload-page="" data-delete-text="">
                <i class="fa fa-trash"></i>
                <span>Delete Record</span>
            </a>
        @endif
    </div>
</div>
