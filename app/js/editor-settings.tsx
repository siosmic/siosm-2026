import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { ToggleControl, PanelRow } from "@wordpress/components";
import { useEntityProp } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import * as React from "react";

const PageSettingsPanel = () => {
  // Récupérer le type de contenu actuel
  const postType = useSelect(
    (select) => select("core/editor").getCurrentPostType(),
    [],
  );

  // N'afficher le panel que sur les Pages
  if (postType !== "page") {
    return null;
  }

  // Récupérer et mettre à jour les meta-données du post
  const [meta, setMeta] = useEntityProp("postType", postType, "meta");

  return (
    <PluginDocumentSettingPanel
      name="page-general-options"
      title="Options de page"
      className="page-general-options-panel"
    >
      <PanelRow>
        <ToggleControl
          label="Masquer le titre"
          checked={!!meta._siosm_page_options}
          onChange={(val) => setMeta({ ...meta, _siosm_page_options: val })}
        />
      </PanelRow>
    </PluginDocumentSettingPanel>
  );
};

registerPlugin("page-general-options-plugin", {
  render: PageSettingsPanel,
});
