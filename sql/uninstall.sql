TRUNCATE TABLE `mc_homepages`;
DROP TABLE `mc_homepages`;

DELETE FROM `mc_admin_access` WHERE `id_module` IN (
        SELECT `id_module` FROM `mc_module` as m WHERE m.name = 'homepages'
    );