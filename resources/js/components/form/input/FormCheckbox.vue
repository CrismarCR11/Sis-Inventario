<template>
  <FormSkeletonCheckbox v-if="loading" :label="label" />
  <v-checkbox
    v-else
    :model-value="modelValue"
    :label="label"
    :color="color"
    :loading="loading"
    :disabled="disabled"
    :error-messages="errorMessage"
    :hide-details="hideDetails"
    class="text-body-2"
    @update:modelValue="(val) => emit('update:modelValue', val)"
  >
  </v-checkbox>
</template>

<script setup lang="ts">
import { useField } from "vee-validate";
import FormSkeletonCheckbox from "../skeleton/FormSkeletonCheckbox.vue";

const props = defineProps({
  name: { type: String, required: true },
  modelValue: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    default: "",
  },
  color: {
    type: String,
    default: "primary",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  hideDetails: {
    type: Boolean,
    default: false,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:modelValue"]);
const { errorMessage, value: fieldValue } = useField(() => props.name);
</script>
