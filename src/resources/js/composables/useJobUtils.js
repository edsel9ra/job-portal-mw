// resources/js/composables/useJobUtils.js
// Helpers de presentación reutilizados en todas las vistas de Jobs.

export function useJobUtils() {
    function statusLabel(status) {
        if (status === 'Abierta') return 'Activa'
        return status ?? ''
    }

    function statusPillClass(status) {
        if (status === 'Abierta') return 'bg-green-100 text-green-700'
        if (status === 'Pausada') return 'bg-yellow-100 text-yellow-800'
        if (status === 'Cerrada') return 'bg-gray-200 text-gray-700'
        return 'bg-blue-100 text-blue-700'
    }

    function formatMoney(v) {
        const n = Number(v)
        if (Number.isNaN(n)) return String(v ?? 0)
        return n.toLocaleString('es-CO')
    }

    function timeAgo(iso) {
        if (!iso) return ''
        const now = Date.now()
        const then = new Date(iso).getTime()
        const diff = Math.max(0, now - then)
        const min = Math.floor(diff / 60000)
        if (min < 1) return 'hace un momento'
        if (min < 60) return `hace ${min} min`
        const hrs = Math.floor(min / 60)
        if (hrs < 24) return `hace ${hrs} h`
        const days = Math.floor(hrs / 24)
        return days === 1 ? 'hace 1 día' : `hace ${days} días`
    }

    return { statusLabel, statusPillClass, formatMoney, timeAgo }
}