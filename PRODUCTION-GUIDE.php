<?php
/**
 * Production Optimization Guide
 * 
 * SÉANCE 5 : Configuration pour la mise en production
 * 
 * Cette file contient les commandes essentielles pour optimiser
 * une application Laravel pour la production.
 */

// ============================================================================
// 1. COMMANDES DE CACHE POUR LA PRODUCTION
// ============================================================================

// Configuration de cache d'application
// php artisan config:cache
// - Cache la configuration (app.php, database.php, etc.)
// - Améliore les perfs en évitant de lire les fichiers config à chaque request
// - ⚠️ À relancer après changement de config en production

// Cache des routes
// php artisan route:cache
// - Compile toutes les routes en un seul fichier
// - Améliore les perfs de résolution des routes
// - ⚠️ À relancer après ajout/modification de routes

// Cache des vues Blade
// php artisan view:cache
// - Compile les vues Blade
// - Améliore les perfs d'affichage

// Cache de tous les configs d'une seule commande
// php artisan optimize
// - Equivalent: config:cache + route:cache + view:cache

// ============================================================================
// 2. VARIABLES D'ENVIRONNEMENT PRODUCTION (.env)
// ============================================================================

/*
APP_ENV=production
APP_DEBUG=false                    // ⚠️ JAMAIS true en production
APP_URL=https://votre-domaine.com

// Base de données (exemple PostgreSQL pour production)
DB_CONNECTION=pgsql
DB_HOST=votre-serveur-db.com
DB_PORT=5432
DB_DATABASE=bibliotech_prod
DB_USERNAME=utilisateur
DB_PASSWORD=motdepassecomplexe

// Cache (utiliser Redis en production)
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

// Session (utiliser Redis ou database)
SESSION_DRIVER=database

// Queue jobs (utiliser database ou Redis)
QUEUE_CONNECTION=database

// Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
MAIL_ENCRYPTION=tls

// Logs
LOG_CHANNEL=stack
LOG_LEVEL=warning

// Sentry (error tracking)
SENTRY_LARAVEL_DSN=https://xxxxx@xxxxx.ingest.sentry.io/xxxxx
*/

// ============================================================================
// 3. SÉCURITÉ EN PRODUCTION
// ============================================================================

/*
CHECKLIST DE SÉCURITÉ:

☐ 1. Force le HTTPS
   - config/app.php: 'url' => 'https://...'
   - middleware: \Illuminate\Http\Middleware\TrustProxies::class
   
☐ 2. Protéger les fichiers sensibles
   - .env ne doit PAS être en version control
   - storage/ et bootstrap/cache/ doivent être écribles
   
☐ 3. Headers de sécurité
   - Content-Security-Policy
   - X-Frame-Options
   - X-Content-Type-Options
   
☐ 4. Base de données
   - Utiliser des credentials complexes
   - Limiter l'accès par IP
   - Configurer des backups réguliers
   
☐ 5. Secrets et tokens
   - APP_KEY généré avec php artisan key:generate
   - JWT keys ou OAuth tokens sécurisés
   - Rotation régulière des secrets
   
☐ 6. Authentification
   - Password hashing avec bcrypt
   - 2FA si possible
   - Rate limiting sur login
*/

// ============================================================================
// 4. DÉPLOIEMENT AVEC GITHUB ACTIONS
// ============================================================================

/*
EXEMPLE DE DÉPLOIEMENT CD vers un serveur:

1. Créer un secret GitHub: DEPLOY_KEY (clé SSH privée)
2. Créer le workflow .github/workflows/deploy.yml

name: Deploy to Production
on:
  push:
    branches: [main]
 
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Deploy via SSH
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.DEPLOY_KEY }}
          script: |
            cd /var/www/html/bibliotech
            git pull origin main
            composer install --no-dev
            php artisan migrate --force
            php artisan cache:clear
            php artisan db:seed --class=ProductionSeeder
            sudo systemctl restart php-fpm
            sudo systemctl restart nginx

3. Vérifier que le déploiement est correctement configuré
*/

// ============================================================================
// 5. MONITORING ET LOGGING
// ============================================================================

/*
Tools recommandées:

1. Sentry (Error Tracking)
   - Capture automatiquement les exceptions
   - Dashboard pour tracking des erreurs

2. Datadog ou New Relic (Performance Monitoring)
   - Monitoring des perfs
   - Alertes en cas de problème

3. ELK Stack (Logging)
   - Elasticsearch+Logstash+Kibana
   - Centralize all logs

4. Healthchecks.io
   - Vérifie que l'app répond correctement
   - Alerts si down
*/

// ============================================================================
// 6. MÉTRIQUES DE PERFORMANCE À MONITORER
// ============================================================================

/*
À suivre en production:

✓ Response time (< 200ms idéalement)
✓ Database query count (éviter N+1 queries)
✓ Server load (CPU, RAM)
✓ Error rate (doit rester < 0.1%)
✓ Uptime (99.9% minimum)
✓ Request per second (RPS)
✓ Cache hit ratio (> 80% idéal)
*/

// ============================================================================
// 7. COMMANDES DE MAINTENANCE
// ============================================================================

/*
// Mettre l'app en mode maintenance
php artisan down --message="Maintenance en cours" --retry=60

// Réappliquer l'app
php artisan up

// Nettoyer les caches
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

// Optimiser l'autoloader
composer install --no-dev --optimize-autoloader

// Vérifier la santé de l'app
php artisan tinker
/// User::count() // Vérifier que la BD est accessible
/// cache()->remember('test', 60, fn() => 'ok'); // Vérifier le cache
*/

// ============================================================================
// 8. CHECKLIST AVANT PRODUCTION
// ============================================================================

/*
☑️ Tests
   ✓ Tous les tests passent
   ✓ Coverage > 80%
   ✓ Tests de charge effectués

☑️ Sécurité
   ✓ .env correct et secret
   ✓ HTTPS activé
   ✓ CSRF tokens actifs
   ✓ Auth implémentée
   ✓ Validation des entrées

☑️ Performance
   ✓ Routes cachées
   ✓ Config cachée
   ✓ Queries optimisées
   ✓ Assets minifiés

☑️ Base de données
   ✓ Migrations exécutées
   ✓ Indexes créés
   ✓ Backups configurés
   ✓ Replication configurée

☑️ Infrastructure
   ✓ SSL certificat valide
   ✓ Firewall configuré
   ✓ Load balancer si nécessaire
   ✓ CDN configuré pour assets

☑️ Monitoring
   ✓ Error tracking activé (Sentry)
   ✓ Performance monitoring
   ✓ Logs centralisés
   ✓ Alertes configurées

☑️ Documentation
   ✓ API documentée
   ✓ Processus de déploiement documenté
   ✓ Runbook pour incidents
*/

echo "✅ BiblioTech est prêt pour la production !";
