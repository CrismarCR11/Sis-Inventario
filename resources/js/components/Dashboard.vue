<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title class="text-h4">
          Bienvenido, {{ auth.user?.name }}
        </v-card-title>
        <v-card-subtitle class="text-h6">
          {{ auth.user?.email }}
        </v-card-subtitle>
        <v-card-text>
          <p>Has iniciado sesión correctamente.</p>
          <p>Token: {{ auth.token?.substring(0, 20) }}...</p>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';

const auth = useAuthStore();
</script>