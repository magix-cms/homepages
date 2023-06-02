<li id="page_{$ms.id_hs}" class="panel list-group-item">
    <header>
        {$type = 'hs_page'}
    <span class="fas fa-arrows-alt"></span> {$ms.name_hs} <sup>({#$type#})</sup>
    <div class="actions">
        <a href="#" class="btn btn-link action_on_record modal_action" data-id="{$ms.id_hs}" data-target="#delete_modal" data-controller="homepages" data-sub="page">
            <span class="fas fa-trash"></span>
        </a>
    </div>
    </header>
</li>