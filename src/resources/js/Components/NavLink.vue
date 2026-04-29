<template>
    <!-- Enlace externo (abre en nueva pestaña) -->
    <a
        v-if="external"
        :href="href"
        target="_blank"
        rel="noopener"
        class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm
               text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors"
    >
        <span class="text-base leading-none flex-shrink-0">{{ icon }}</span>
        <span class="truncate">{{ label }}</span>
        <span class="ml-auto text-xs text-gray-300">↗</span>
    </a>

    <!-- Enlace Inertia interno -->
    <Link
        v-else
        :href="href"
        class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-colors"
        :class="isActive
            ? 'bg-gray-900 text-white font-medium'
            : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800'"
    >
        <span class="text-base leading-none flex-shrink-0">{{ icon }}</span>
        <span class="truncate">{{ label }}</span>
    </Link>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const props = defineProps({
    href:     { type: String,  required: true },
    icon:     { type: String,  required: true },
    label:    { type: String,  required: true },
    external: { type: Boolean, default: false },
})

const page = usePage()

const isActive = computed(() => {
    try {
        const path = new URL(props.href, window.location.origin).pathname
        return page.url.startsWith(path)
    } catch {
        return false
    }
})
</script>