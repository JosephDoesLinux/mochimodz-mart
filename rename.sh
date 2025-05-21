#!/usr/bin/env bash
#
# Backup all .php files and replace "PC-Pastel" → "MochiModz Mart"

# 1. Find all .php files
# 2. For each file, make an in-place replacement, keeping a .bak backup
find . -type f -name '*.php' \
  -exec sed -i.bak 's/PC-Pastel/MochiModz Mart/g' {} +

echo "✅ Replacement complete. Backups saved with .bak extension."
