<template>
  <v-switch
    :label="label"
    :id="name"
    v-model="value"
    :name="name"
    :disabled="disabled"
    :error-messages="errorMessage"
    :density="density"
    :color="color"
    @blur="handleInputBlur"
    hide-details="auto"
    :inset="inset"
    :true-value="true"
    :false-value="false"
  />
</template>

<script setup lang="ts">
import { watch } from 'vue'
import { useField } from 'vee-validate'
import type { IFormInput } from '@/core/types/IForm'

type SwitchValue = boolean | null

interface IFormSwitch extends Omit<IFormInput, 'type' | 'placeholder' | 'icon' | 'variant'> {
  inset?: boolean
  density?: 'default' | 'comfortable' | 'compact'
  color?: string
  initialValue?: SwitchValue
}

const props = withDefaults(defineProps<IFormSwitch>(), {
  label: '',
  disabled: false,
  autocomplete: 'off',
  inset: false,
  density: 'comfortable',
  color: 'primary',
  initialValue: false,
})

const { value, errorMessage, handleBlur } = useField<SwitchValue>(() => props.name, undefined, {
  initialValue: props.initialValue,
})

const emit = defineEmits<{
  (e: 'updated', payload: SwitchValue): void
  (e: 'blurred'): void
}>()

watch(value, (newVal) => {
    emit('updated', newVal)
})

const handleInputBlur = (e: FocusEvent) => {
  handleBlur(e)
  emit('blurred')
}
</script>