!function(){"use strict";var e=window.wp.plugins,t=window.wp.element,o=window.wp.components,r=window.wp.data,n=window.wp.editPost,l=window.wp.i18n;(0,e.registerPlugin)("plugin-color-settings",{icon:null,render:()=>{const e=(0,r.useSelect)((e=>e("core/editor").getCurrentPostType()));if(!["post","page","event"].includes(e))return(0,t.createElement)(t.Fragment,null);const{meta:i,meta:{page_colors:s}}=(0,r.useSelect)((e=>({meta:e("core/editor").getEditedPostAttribute("meta")||{}}))),a=(0,r.useSelect)("core/block-editor").getSettings().colors,{editPost:c}=(0,r.useDispatch)("core/editor"),[u,g]=(0,t.useState)(s);return(0,t.useEffect)((()=>{c({meta:{...i,page_colors:u}})}),[u]),(0,t.createElement)(n.PluginDocumentSettingPanel,{name:"page-color-settings",title:(0,l.__)("Color Settings","blueprint"),className:"page-color-settings"},(0,t.createElement)("h3",null,(0,l.__)("Primary Color","blueprint")),(0,t.createElement)(o.ColorPalette,{colors:a,value:u?.primary_color,onChange:e=>{var t;t=e,g({...u,primary_color:t})},defaultValue:"#000000",disableCustomColors:!1}))}})}();