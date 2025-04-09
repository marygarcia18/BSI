<script setup>
defineProps(['id', 'class', 'modelValue']);
defineEmits(['update:modelValue']);
</script>

<template>
    <select
        :id="id"
        :class="class"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <slot />
    </select>
</template>
