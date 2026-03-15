<template>
    <v-textarea 
        :label="label"
        :id="name" 
        v-model="value" 
        :name="name" 
        :placeholder="placeholder" 
        :disabled="disabled"
        :autocomplete="autocomplete" 
        :error-messages="errorMessage" 
        variant="outlined" 
        density="comfortable"
        color="primary"
        :rows="rows"
        :auto-grow="autoGrow"
        @blur="handleInputBlur"
        hide-details="auto"
    >
        <template v-if="icon" #prepend-inner>
            <v-icon :icon="icon" />
        </template>
    </v-textarea>
</template>

<script setup lang="ts">
import { watch } from 'vue'
import { useField } from 'vee-validate'
import type { IFormInput } from '@/core/types/IForm'

interface IFormTextarea extends Omit<IFormInput, 'type'> {
    rows?: number;
    autoGrow?: boolean;
}

const props = withDefaults(defineProps<IFormTextarea>(), {
    label: '',
    placeholder: '',
    disabled: false,
    autocomplete: 'off',
    icon: undefined,
    variant: 'outlined',
    rows: 3,
    autoGrow: false
})

const { value, errorMessage, handleBlur } = useField<string>(() => props.name)

const emit = defineEmits<{
  (e: 'updated', payload: any): void
  (e: 'blurred'): void
}>();

watch(value, (newVal) => {
    emit('updated', newVal)
})

const handleInputBlur = (e: FocusEvent) => {
    handleBlur(e)
    emit('blurred')
}
</script>