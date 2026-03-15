<template>
  <v-tooltip :text="tooltip" location="top">
    <template v-slot:activator="{ props: tooltipProps }">
      <v-btn v-bind="tooltipProps" 
        :color="color" 
        size="small" 
        icon 
        variant="text"
        class="action-btn"
        @click="onClick" 
        v-motion
        :initial="{ scale: 0.8 }"
        :enter="{ scale: 1, transition: { duration: 200 } }"
        :aria-label="tooltip"
        :loading="loading"
      >
        <v-icon :icon="icon"></v-icon>
      </v-btn>
    </template>
  </v-tooltip>
</template>

<script setup lang="ts">
interface ActionButtonProps {
  tooltip: string;
  icon: string;
  color?: string;
  loading?: boolean;
  onClick: () => void;
}

withDefaults(defineProps<ActionButtonProps>(), {
  color: 'primary',
  loading: false,
});
</script>

<style scoped>
.action-btn {
  border-radius: 50%;
  margin: 0 4px;
  transition: all 0.2s ease;
}

.action-btn:hover {
  transform: scale(1.2);
  background-color: rgba(0, 0, 0, 0.05);
}
</style>