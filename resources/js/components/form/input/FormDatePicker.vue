<template>
  <v-menu v-model="menuIsOpen" :close-on-content-click="false" offset-y>
    <template v-slot:activator="{ props: activatorProps }">
      <v-text-field
        :label="label"
        :model-value="formattedDate"
        :name="name"
        :disabled="disabled"
        :error-messages="errorMessage"
        readonly
        v-bind="activatorProps"
        :prepend-inner-icon="icon || 'mdi-calendar'"
        variant="outlined"
        hide-details="auto"
        density="compact"
      />
    </template>
    <v-date-picker
      v-model="tempDate"
      :max="maxDate"
      :min="minDate"
      @update:modelValue="handleDateChange"
      color="primary"
      class="compact-date-picker"
    />
  </v-menu>
</template>

<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { useField } from "vee-validate";
import dayjs from "dayjs";

const props = withDefaults(
  defineProps<{
    name: string;
    label?: string;
    disabled?: boolean;
    icon?: string;
    maxDate?: string;
    minDate?: string;
    dateFormat?: string;
    modelValue?: string;
    defaultValue?: string;
  }>(),
  {
    label: "",
    disabled: false,
    icon: undefined,
    maxDate: undefined,
    minDate: undefined,
    dateFormat: "YYYY-MM-DD",
    modelValue: undefined,
    defaultValue: dayjs().format("YYYY-MM-DD"),
  }
);

const emit = defineEmits(["update:modelValue"]);
const { value, errorMessage } = useField<string>(() => props.name, undefined, {
  initialValue: props.modelValue || props.defaultValue,
});
const menuIsOpen = ref(false);
const tempDate = ref(value.value);

const formattedDate = computed(() =>
  value.value ? dayjs(value.value).format(props.dateFormat) : ""
);

const handleDateChange = (newVal: string) => {
  if (newVal) {
    const dateString = dayjs(newVal).format("YYYY-MM-DD");
    
    if (dateString !== value.value) {
      value.value = dateString;
      emit("update:modelValue", dateString);
      menuIsOpen.value = false;
    }
  }
};

watch(
  () => props.modelValue,
  (newVal) => {
    if (newVal && newVal !== value.value) {
      value.value = newVal;
      tempDate.value = newVal;
    }
  }
);
</script>