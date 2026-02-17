<template>
  <v-container fluid class="fill-height">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Registrarse</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleSubmit">
              <v-text-field
                v-model="form.name"
                label="Nombre"
                prepend-icon="mdi-account"
                required
                :error-messages="errors.name"
              ></v-text-field>
              <v-text-field
                v-model="form.email"
                label="Email"
                prepend-icon="mdi-email"
                type="email"
                required
                :error-messages="errors.email"
              ></v-text-field>
              <v-text-field
                v-model="form.password"
                label="Contraseña"
                prepend-icon="mdi-lock"
                type="password"
                required
                :error-messages="errors.password"
              ></v-text-field>
              <v-text-field
                v-model="form.password_confirmation"
                label="Confirmar Contraseña"
                prepend-icon="mdi-lock-check"
                type="password"
                required
                :error-messages="errors.password_confirmation"
              ></v-text-field>
              
              <v-alert v-if="errorMessage" type="error" class="mb-3">
                {{ errorMessage }}
              </v-alert>
              
              <v-btn
                type="submit"
                color="primary"
                block
                :loading="loading"
              >
                Registrarse
              </v-btn>
            </v-form>
          </v-card-text>
          <v-card-text class="text-center">
            <router-link to="/login">¿Ya tienes cuenta? Inicia sesión</router-link>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const loading = ref(false)
const errorMessage = ref('')
const errors = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const handleSubmit = async () => {
    loading.value = true
    errorMessage.value = ''
    Object.keys(errors).forEach(key => errors[key as keyof typeof errors] = '')
    
    try {
        await auth.register(form)
    } catch (error: any) {
        if (error.response?.data?.errors) {
            const serverErrors = error.response.data.errors
            Object.keys(serverErrors).forEach(key => {
                if (key in errors) {
                    errors[key as keyof typeof errors] = serverErrors[key][0]
                }
            })
        } else {
            errorMessage.value = error.response?.data?.message || 'Error al registrarse'
        }
    } finally {
        loading.value = false
    }
}
</script>