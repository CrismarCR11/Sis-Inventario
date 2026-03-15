<template>
  <FormSkeletonSelect
    v-if="loading"
    :label="label"
    :icon="icon"
    :multiple="multiple"
    :has-error="!!errorMessage"
  />
  <v-autocomplete
    v-else
    :label="label"
    :id="name"
    v-model="internalValue"
    v-model:search="searchInput"
    :items="filteredItems"
    :name="name"
    :placeholder="placeholder"
    :item-title="itemTitle"
    :item-value="itemValue"
    :loading="loading"
    :disabled="disabled"
    :error-messages="errorMessage"
    :multiple="multiple"
    :chips="multiple"
    :closable-chips="multiple"
    :search="searchable"
    :menu-props="menuProps"
    :return-object="false"
    variant="outlined"
    density="comfortable"
    color="primary"
    clearable
    class="custom-select-chips"
    hide-details="auto"
    autocomplete="off"
  >
    <template v-if="icon" #prepend-inner>
      <v-icon :icon="icon" />
    </template>

    <template v-if="multiple" #chip="{ item }">
      <v-chip
        class="ma-1"
        close
        @click:close="removeItem(item)"
      >
        {{ getItemTitle(item) }}
      </v-chip>
    </template>

    <template #no-data>
      <div class="px-4 py-2 text-caption">
        <template v-if="searchInput && searchInput.length >= minSearchChars">
          No se encontraron resultados para "{{ searchInput }}"
        </template>
        <template v-else>
          No hay opciones disponibles
        </template>
      </div>
    </template>
  </v-autocomplete>
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { useField } from "vee-validate";
import FormSkeletonSelect from "../skeleton/FormSkeletonSelect.vue";

const props = defineProps({
  name: { type: String, required: true },
  label: { type: String, default: "" },
  items: { type: Array, default: () => [] },
  placeholder: { type: String, default: "" },
  itemTitle: { type: String, default: "title" },
  itemValue: { type: String, default: "value" },
  loading: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
  multiple: { type: Boolean, default: false },
  icon: { type: String, default: "" },
  searchable: { type: Boolean, default: true },
  minSearchChars: { type: Number, default: 1 },
  caseSensitive: { type: Boolean, default: false },
  modelValue: {
    type: [String, Number, Array, null],
    default: null
  }
});

const emit = defineEmits(["update:modelValue"]);
const { errorMessage, value: fieldValue } = useField(() => props.name);
const searchInput = ref("");

const normalizedValue = computed({
  get() {
    if (props.multiple) {
      return Array.isArray(props.modelValue) ? props.modelValue : [];
    } else {
      return props.modelValue;
    }
  },
  set(val) {
    if (props.multiple) {
      emit("update:modelValue", Array.isArray(val) ? val : []);
      fieldValue.value = Array.isArray(val) ? val : [];
    } else {
      emit("update:modelValue", val);
      fieldValue.value = val;
    }
  }
});

const internalValue = computed({
  get: () => normalizedValue.value,
  set: (val) => (normalizedValue.value = val),
});

const getItemTitle = (itemValueSelected: any) => {
  const itemFound = props.items.find(
    (opt) => opt[props.itemValue] === itemValueSelected.value
  );
  return itemFound ? itemFound[props.itemTitle] : itemValueSelected;
};

const removeItem = (item: any) => {
  console.log(item);
  
  if (!props.multiple) return;
  if (!Array.isArray(internalValue.value)) return;

  const updated = internalValue.value.filter((v) => v !== item.value);
  internalValue.value = updated;
};

watch(
  () => props.items,
  () => {
    searchInput.value = "";
  },
  { deep: true }
);

const filteredItems = computed(() => {
  const items = Array.isArray(props.items) ? props.items : [];

  if (!searchInput.value || searchInput.value.length < props.minSearchChars) {
    return items;
  }

  const searchTerm = props.caseSensitive
    ? searchInput.value
    : searchInput.value.toLowerCase();

  return items.filter((item: any) => {
    const title = props.caseSensitive
      ? String(item[props.itemTitle])
      : String(item[props.itemTitle]).toLowerCase();

    return title.includes(searchTerm);
  });
});

const menuProps = {
  closeOnContentClick: false,
  maxHeight: 400,
  transition: "slide-y-transition",
  contentClass: "select-menu-content",
  virtual: props.items.length > 100,
  itemHeight: 48,
};
</script>

<style>
.select-menu-content {
  scroll-behavior: smooth;
}
.custom-select-chips .v-field__input {
  font-size: 12px !important;
  min-height: 40px;
}
.custom-select-chips .v-chip {
  font-size: 12px !important;
  margin: 2px;
}
.custom-select-chips .v-field__input input::placeholder {
  opacity: 0.6;
  color: inherit;
}
</style>
