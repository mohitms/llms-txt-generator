#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST_DIR="${ROOT_DIR}/dist"
ZIP_NAME="simple-llms-txt.zip"

mkdir -p "${DIST_DIR}"

pushd "${ROOT_DIR}" >/dev/null

ZIP_PATH="${DIST_DIR}/${ZIP_NAME}"
rm -f "${ZIP_PATH}"

zip -rq "${ZIP_PATH}" . \
  -x "dist/*" \
  -x "node_modules/*" \
  -x "vendor/*" \
  -x "tests/*" \
  -x ".git/*" \
  -x ".github/*" \
  -x "*.zip" \
  -x "*.log" \
  -x "*.cache" \
  -x "scripts/build-zip.sh" \
  -x "composer.lock" \
  -x "package-lock.json" \
  -x "package-lock.json*" \
  -x "npm-debug.log" \
  -x "yarn.lock"

popd >/dev/null

echo "Created ${ZIP_PATH}"
