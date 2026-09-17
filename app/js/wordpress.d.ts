/**
 * Déclarations de types TypeScript pour les modules de l'éditeur de blocs WordPress (Gutenberg).
 * Ce fichier évite d'installer de nombreuses dépendances de types complexes dans node_modules
 * et permet de supprimer les alertes "Cannot find module" dans l'IDE tout en fournissant l'autocomplétion.
 */

declare module "@wordpress/plugins" {
  export function registerPlugin(
    name: string,
    config: { render: import('react').ComponentType<any> }
  ): void;
}

declare module "@wordpress/edit-post" {
  export interface PluginDocumentSettingPanelProps {
    name: string;
    title: string;
    className?: string;
    children?: import('react').ReactNode;
  }
  export const PluginDocumentSettingPanel: import('react').ComponentType<PluginDocumentSettingPanelProps>;
}

declare module "@wordpress/components" {
  export interface TextControlProps {
    label: string;
    value: string;
    onChange: (value: string) => void;
  }
  export const TextControl: import('react').ComponentType<TextControlProps>;

  export interface ToggleControlProps {
    label: string;
    checked: boolean;
    onChange: (value: boolean) => void;
  }
  export const ToggleControl: import('react').ComponentType<ToggleControlProps>;

  export interface CheckboxControlProps {
    label: string;
    checked: boolean;
    onChange: (value: boolean) => void;
  }
  export const CheckboxControl: import('react').ComponentType<CheckboxControlProps>;

  export interface SelectControlProps {
    label: string;
    value: string;
    options: { label: string; value: string; disabled?: boolean }[];
    onChange: (value: string) => void;
  }
  export const SelectControl: import('react').ComponentType<SelectControlProps>;

  export interface RadioControlProps {
    label: string;
    selected: string;
    options: { label: string; value: string }[];
    onChange: (value: string) => void;
  }
  export const RadioControl: import('react').ComponentType<RadioControlProps>;

  export interface TextareaControlProps {
    label: string;
    value: string;
    onChange: (value: string) => void;
    rows?: number;
  }
  export const TextareaControl: import('react').ComponentType<TextareaControlProps>;

  export interface DateTimePickerProps {
    currentDate: string;
    onChange: (date: string) => void;
    is12Hour?: boolean;
  }
  export const DateTimePicker: import('react').ComponentType<DateTimePickerProps>;

  export interface ColorPaletteProps {
    colors?: { name: string; color: string }[];
    value: string;
    onChange: (color: string) => void;
    disableCustomColors?: boolean;
  }
  export const ColorPalette: import('react').ComponentType<ColorPaletteProps>;

  export interface PanelRowProps {
    children?: import('react').ReactNode;
  }
  export const PanelRow: import('react').ComponentType<PanelRowProps>;
}

declare module "@wordpress/core-data" {
  export function useEntityProp(
    kind: string,
    name: string,
    key: string
  ): [any, (value: any) => void, any];
}

declare module "@wordpress/data" {
  export function useSelect<T>(
    mapSelect: (select: (storeName: string) => any) => T,
    deps?: any[]
  ): T;
}
