#!/bin/bash

# TCExam REST API Test Script
# Tests all 5 user management endpoints with Bearer token authentication

BASE_URL="http://localhost/tcexam/admin/code/tce_api.php"
TIMESTAMP=$(date +%s)
TEST_USER="testuser_${TIMESTAMP}"
TEST_EMAIL="test_${TIMESTAMP}@example.com"

echo "=========================================="
echo "TCExam REST API Test Suite"
echo "=========================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 0: Login to get Bearer token
echo -e "${BLUE}[SETUP] Logging in to get Bearer token${NC}"
echo "Request: POST api/auth.login"
echo "Params: user_name=admin, password=admin123"
echo ""

LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/auth.login" \
  -d "user_name=admin&password=admin123")

echo "Response:"
echo "$LOGIN_RESPONSE" | jq . 2>/dev/null || echo "$LOGIN_RESPONSE"
echo ""

TOKEN=$(echo "$LOGIN_RESPONSE" | jq -r '.token' 2>/dev/null)

if [ -z "$TOKEN" ] || [ "$TOKEN" = "null" ]; then
    echo -e "${RED}❌ FAILED: Could not get authentication token${NC}"
    echo ""
    exit 1
fi

echo -e "${GREEN}✓ Logged in successfully, token obtained${NC}"
echo ""

# Test 1: Add User
echo -e "${BLUE}[TEST 1] Adding User${NC}"
echo "Request: POST api/user.add"
echo "Params: user_name=$TEST_USER, firstname=Test, lastname=User, email=$TEST_EMAIL, user_level=1"
echo ""

ADD_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/user.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_name=$TEST_USER&password=TestPass123&firstname=Test&lastname=User&email=$TEST_EMAIL&user_level=1")

echo "Response:"
echo "$ADD_RESPONSE" | jq . 2>/dev/null || echo "$ADD_RESPONSE"
echo ""

# Extract user_id from response
USER_ID=$(echo "$ADD_RESPONSE" | jq -r '.user_id' 2>/dev/null)

if [ -z "$USER_ID" ] || [ "$USER_ID" = "null" ]; then
    echo -e "${RED}❌ FAILED: Could not get user_id${NC}"
    echo ""
    exit 1
fi

echo -e "${GREEN}✓ User created with ID: $USER_ID${NC}"
echo ""

# Test 2: Get Single User
echo -e "${BLUE}[TEST 2] Getting Single User${NC}"
echo "Request: GET api/user.get&user_id=$USER_ID"
echo ""

GET_RESPONSE=$(curl -s "$BASE_URL?route=api/user.get&user_id=$USER_ID" \
  -H "Authorization: Bearer $TOKEN")

echo "Response:"
echo "$GET_RESPONSE" | jq . 2>/dev/null || echo "$GET_RESPONSE"
echo ""

GET_STATUS=$(echo "$GET_RESPONSE" | jq -r '.status' 2>/dev/null)
if [ "$GET_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ User retrieved successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not retrieve user${NC}"
fi
echo ""

# Test 3: List Users
echo -e "${BLUE}[TEST 3] Listing Users${NC}"
echo "Request: GET api/user.list&page=1&limit=10"
echo ""

LIST_RESPONSE=$(curl -s "$BASE_URL?route=api/user.list&page=1&limit=10" \
  -H "Authorization: Bearer $TOKEN")

echo "Response (first 500 chars):"
echo "$LIST_RESPONSE" | jq . 2>/dev/null | head -n 30 || echo "$LIST_RESPONSE" | head -c 500
echo ""

LIST_STATUS=$(echo "$LIST_RESPONSE" | jq -r '.status' 2>/dev/null)
if [ "$LIST_STATUS" = "success" ]; then
    USER_COUNT=$(echo "$LIST_RESPONSE" | jq '.users | length' 2>/dev/null)
    echo -e "${GREEN}✓ Listed users (total in response: $USER_COUNT)${NC}"
else
    echo -e "${RED}❌ FAILED: Could not list users${NC}"
fi
echo ""

# Test 4: Update User
echo -e "${BLUE}[TEST 4] Updating User${NC}"
echo "Request: POST api/user.edit&user_id=$USER_ID"
echo "Params: firstname=Updated, email=updated_${TIMESTAMP}@example.com"
echo ""

UPDATE_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/user.edit" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_id=$USER_ID&firstname=Updated&email=updated_${TIMESTAMP}@example.com")

echo "Response:"
echo "$UPDATE_RESPONSE" | jq . 2>/dev/null || echo "$UPDATE_RESPONSE"
echo ""

UPDATE_STATUS=$(echo "$UPDATE_RESPONSE" | jq -r '.status' 2>/dev/null)
if [ "$UPDATE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ User updated successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not update user${NC}"
fi
echo ""

# Test 5: Verify Update
echo -e "${BLUE}[TEST 5] Verifying Update${NC}"
echo "Request: GET api/user.get&user_id=$USER_ID"
echo ""

VERIFY_RESPONSE=$(curl -s "$BASE_URL?route=api/user.get&user_id=$USER_ID" \
  -H "Authorization: Bearer $TOKEN")

echo "Response:"
echo "$VERIFY_RESPONSE" | jq . 2>/dev/null || echo "$VERIFY_RESPONSE"
echo ""

VERIFY_EMAIL=$(echo "$VERIFY_RESPONSE" | jq -r '.user.email' 2>/dev/null)
if [ "$VERIFY_EMAIL" = "updated_${TIMESTAMP}@example.com" ]; then
    echo -e "${GREEN}✓ Update verified successfully${NC}"
else
    echo -e "${YELLOW}⚠ Email not updated as expected${NC}"
fi
echo ""

# Test 6: Delete User
echo -e "${BLUE}[TEST 6] Deleting User${NC}"
echo "Request: POST api/user.delete&user_id=$USER_ID"
echo ""

DELETE_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/user.delete" \
  -H "Authorization: Bearer $TOKEN" \
  -d "user_id=$USER_ID")

echo "Response:"
echo "$DELETE_RESPONSE" | jq . 2>/dev/null || echo "$DELETE_RESPONSE"
echo ""

DELETE_STATUS=$(echo "$DELETE_RESPONSE" | jq -r '.status' 2>/dev/null)
if [ "$DELETE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ User deleted successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not delete user${NC}"
fi
echo ""

# Test 7: Verify Deletion
echo -e "${BLUE}[TEST 7] Verifying Deletion${NC}"
echo "Request: GET api/user.get&user_id=$USER_ID"
echo ""

VERIFY_DEL=$(curl -s "$BASE_URL?route=api/user.get&user_id=$USER_ID" \
  -H "Authorization: Bearer $TOKEN")

echo "Response:"
echo "$VERIFY_DEL" | jq . 2>/dev/null || echo "$VERIFY_DEL"
echo ""

VERIFY_DEL_STATUS=$(echo "$VERIFY_DEL" | jq -r '.status' 2>/dev/null)
if [ "$VERIFY_DEL_STATUS" = "error" ]; then
    echo -e "${GREEN}✓ Deletion verified - user no longer exists${NC}"
else
    echo -e "${YELLOW}⚠ User still exists after deletion attempt${NC}"
fi
echo ""

# Summary
echo "=========================================="
echo -e "${GREEN}✓ All tests completed!${NC}"
echo "=========================================="
echo ""
