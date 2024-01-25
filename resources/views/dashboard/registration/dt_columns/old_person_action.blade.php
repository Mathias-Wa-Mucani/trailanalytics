<div class="actions">
    <i class="fa fa-list"></i>
    <div class="actions-list">
        <a href="#" title="Group Application: {{ @$record->elder_number }}" class="clarify_tertiary-">
            <i class="fa fa-folder-open"></i>
            <span> View Details </span>
        </a>

        <a class="dynamic-modal" data-modal-target="modal-large" title="Edit: Elder Person - {{ @$record->elder_number }}"
            href="{{ route('module.create', ['Module' => 'registration', 'Model' => ModelHelper::TableFromView(class_basename(@$record)), 'ModelId' => GeneralHelper::encrypt_data(@$record->id), 'Section' => 'old_person']) }}">
            <i class="fa fa-edit"></i> Edit Record
        </a>

        <a href="javascript:;" class="delete-row danger"
            data-model="{{ ModelHelper::TableFromView(class_basename(@$record)) }}" data-model-id="{{ @$record->id }}"
            data-reload-page="" data-delete-text="">
            <i class="fa fa-trash"></i>
            <span>Delete Record</span>
        </a>
    </div>
</div>
