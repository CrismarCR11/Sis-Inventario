<template>
  <div class="v-input">
    <label v-if="label" class="v-label">
      {{ label }}
    </label>
    <VueDatePicker
      :model-value="value"
      @update:model-value="handleChange"
      :name="name"
      :placeholder="placeholder"
      :disabled="disabled"
      :enable-time-picker="true"
      :is-24="true"
      :auto-apply="false"
      :locale="locale"
      :cancelText="textInput.cancel" 
      :selectText="textInput.apply"
      :class="{ 'is-invalid': errorMessage }"
      @blur="handleInputBlur"
      teleport-center
    >
      <template #input-icon>
        <v-icon v-if="icon" :icon="icon" class="mx-2"/>
      </template>
    </VueDatePicker>
    <div v-if="errorMessage" class="v-messages error--text">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { watch } from 'vue';
import { useField } from 'vee-validate';
import type { IFormInput } from '@/core/types/IForm';

interface IFormDateTimePicker extends Omit<IFormInput, 'type'> {
  locale?: string;
  timePicker?: boolean;
}

const props = withDefaults(defineProps<IFormDateTimePicker>(), {
  label: '',
  placeholder: 'Seleccione fecha y hora',
  disabled: false,
  autocomplete: 'off',
  icon: undefined,
  locale: 'es',
  timePicker: true
});

const textInput = {
  apply: 'Aplicar',
  cancel: 'Cancelar',
  input: 'Seleccionar fecha y hora'
};

const { value, errorMessage, handleBlur } = useField<Date | string | null>(() => props.name);

const emit = defineEmits<{
  (e: 'updated', payload: Date | string | null): void;
  (e: 'blurred'): void;
}>();

watch(value, (newVal) => {
  emit('updated', newVal);
});

const handleChange = (newValue: Date | null) => {
  value.value = newValue;
};

const handleInputBlur = (e: FocusEvent) => {
  handleBlur(e);
  emit('blurred');
};
</script>

<style scoped>
.v-input {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.v-label {
  font-size: 0.875rem;
  color: rgba(0, 0, 0, 0.6);
  margin-bottom: 4px;
}
</style>