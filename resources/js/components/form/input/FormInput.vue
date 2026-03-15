<template>
  <FormSkeletonInput
    v-if="loading"
    :label="label"
    :icon="icon"
    :type="type"
    :has-error="!!errorMessage"
  />
  <v-text-field 
    v-else
    :label="label"
    :id="name"
    v-model="value"
    :loading="loading"
    :type="showPassword ? 'text' : type"
    :name="name"
    :placeholder="placeholder"
    :disabled="disabled"
    :autocomplete="autocomplete"
    :error-messages="errorMessage"
    variant="outlined"
    density="comfortable"
    color="primary"
    :append-inner-icon="type === 'password' ? showPasswordIcon : undefined"
    @click:append-inner="togglePasswordVisibility"
    @blur="handleInputBlur"
    :step="type === 'number' ? step : undefined"
    :min="type === 'number' ? min : undefined"
  >
    <template v-if="icon" #prepend-inner>
      <v-icon :icon="icon" />
    </template>
  </v-text-field>
</template>

<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { useField } from "vee-validate";
import type { IFormInput } from "@/core/types/IForm";
import FormSkeletonInput from "../skeleton/FormSkeletonInput.vue";

const props = withDefaults(defineProps<IFormInput>(), {
  type: "text",
  label: "",
  placeholder: "",
  disabled: false,
  loading: false,
  autocomplete: "off",
  icon: undefined,
  variant: "outlined",
  step: "1",
  min: "0",
});

const { value, errorMessage, handleBlur } = useField<string>(() => props.name);

const emit = defineEmits<{
  (e: "updated", payload: any): void;
  (e: "blurred"): void;
}>();

const showPassword = ref(false);
const showPasswordIcon = computed(() =>
  showPassword.value ? "mdi-eye-off" : "mdi-eye"
);
const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

watch(value, (newVal) => {
  emit("updated", newVal);
});

const handleInputBlur = (e: FocusEvent) => {
  if (props.type === "number" && value.value !== "" && value.value !== null) {
    const num = parseFloat(value.value as unknown as string);
    if (!isNaN(num)) {
      value.value = num.toFixed(2);
    }
  }
  handleBlur(e);
  emit("blurred");
};
</script>
